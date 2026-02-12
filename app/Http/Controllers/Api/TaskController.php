<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $q = Task::query()
            ->where('user_id', $user->id)
            ->with(['subject:id,name', 'tags:id,name', 'subtasks', 'attachments']);

        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        if ($request->filled('subject_id')) {
            $q->where('subject_id', $request->integer('subject_id'));
        }

        if ($request->filled('due_from')) {
            $q->where('due_at', '>=', $request->date('due_from'));
        }

        if ($request->filled('due_to')) {
            $q->where('due_at', '<=', $request->date('due_to'));
        }

        if ($request->filled('q')) {
            $term = $request->string('q')->toString();
            $q->where(function ($w) use ($term) {
                $w->where('title', 'ilike', "%{$term}%")
                  ->orWhere('description', 'ilike', "%{$term}%");
            });
        }

        $sort = $request->string('sort', 'due_at')->toString(); // due_at|created_at|priority
        $dir = $request->string('dir', 'asc')->toString(); // asc|desc
        $dir = in_array($dir, ['asc','desc']) ? $dir : 'asc';
        $sort = in_array($sort, ['due_at','created_at','priority','status']) ? $sort : 'due_at';

        $q->orderBy($sort, $dir)->orderBy('id', 'desc');

        return $q->paginate(15);
    }

    public function store(StoreTaskRequest $request)
    {
        $user = $request->user();

        // subject_id és tag_ids csak akkor oké, ha a useré
        $subjectId = $request->input('subject_id');
        if ($subjectId) {
            $owns = $user->subjects()->whereKey($subjectId)->exists();
            abort_unless($owns, 403);
        }

        $task = Task::create([
            'user_id' => $user->id,
            'subject_id' => $subjectId,
            'title' => $request->string('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status', 'todo'),
            'priority' => $request->input('priority', 'medium'),
            'due_at' => $request->input('due_at'),
            'estimate_minutes' => $request->input('estimate_minutes'),
        ]);

        $tagIds = $request->input('tag_ids', []);
        if (!empty($tagIds)) {
            $valid = $user->tags()->whereIn('id', $tagIds)->pluck('id')->all();
            $task->tags()->sync($valid);
        }

        return response()->json($task->load(['subject','tags','subtasks','attachments']), 201);
    }

    public function show(Request $request, Task $task)
    {
        $this->authorize('view', $task);
        return $task->load(['subject','tags','subtasks','attachments']);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $user = $request->user();

        if ($request->has('subject_id')) {
            $subjectId = $request->input('subject_id');
            if ($subjectId) {
                $owns = $user->subjects()->whereKey($subjectId)->exists();
                abort_unless($owns, 403);
            }
            $task->subject_id = $subjectId;
        }

        foreach (['title','description','status','priority','due_at','estimate_minutes'] as $f) {
            if ($request->has($f)) $task->{$f} = $request->input($f);
        }

        // completed_at automatikus
        if ($request->has('status')) {
            if ($task->status === 'done' && $task->completed_at === null) {
                $task->completed_at = now();
            }
            if ($task->status !== 'done') {
                $task->completed_at = null;
            }
        }

        $task->save();

        if ($request->has('tag_ids')) {
            $tagIds = $request->input('tag_ids', []);
            $valid = $user->tags()->whereIn('id', $tagIds)->pluck('id')->all();
            $task->tags()->sync($valid);
        }

        return $task->load(['subject','tags','subtasks','attachments']);
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->noContent();
    }

    public function patchStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'status' => ['required', 'in:todo,doing,done'],
        ]);

        $task->status = $data['status'];
        $task->completed_at = ($data['status'] === 'done') ? now() : null;
        $task->save();

        return $task->fresh();
    }
}
