<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{Task, Subject, Tag, Subtask, Attachment};
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();

        $q = Task::query()
            ->where('user_id', $user->id)
            ->with(['subject', 'tags', 'subtasks', 'attachments']);

        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        if ($request->filled('subject_id')) {
            $q->where('subject_id', (int)$request->input('subject_id'));
        }

        if ($request->filled('q')) {
            $term = $request->string('q')->toString();
            $q->where(function ($w) use ($term) {
                $w->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $sort = $request->string('sort', 'due_at')->toString();
        $dir = $request->string('dir', 'asc')->toString();
        $dir = in_array($dir, ['asc','desc']) ? $dir : 'asc';
        $sort = in_array($sort, ['due_at','created_at','priority','status']) ? $sort : 'due_at';

        $q->orderBy($sort, $dir)->orderBy('id', 'desc');

        $tasks = $q->paginate(12)->withQueryString();

        $subjects = Subject::where('user_id', $user->id)->orderBy('name')->get();
        $tags = Tag::where('user_id', $user->id)->orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'subjects', 'tags'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $subjects = Subject::where('user_id', $user->id)->orderBy('name')->get();
        $tags = Tag::where('user_id', $user->id)->orderBy('name')->get();

        return view('tasks.create', compact('subjects', 'tags'));
    }

public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|string',
        'subject_id' => 'nullable|exists:subjects,id',
        'due_at' => 'nullable|date',
        'estimate_minutes' => 'nullable|integer',
    ]);

    $data['user_id'] = $request->user()->id;

    \App\Models\Task::create($data);

    return redirect()->route('tasks.index')
        ->with('status', 'Feladat létrehozva.');
}

    public function show(Request $request, Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['subject','tags','subtasks','attachments']);
        $subjects = Subject::where('user_id', $request->user()->id)->orderBy('name')->get();
        $tags = Tag::where('user_id', $request->user()->id)->orderBy('name')->get();

        return view('tasks.show', compact('task', 'subjects', 'tags'));
    }

    public function edit(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $subjects = Subject::where('user_id', $request->user()->id)->orderBy('name')->get();
        $tags = Tag::where('user_id', $request->user()->id)->orderBy('name')->get();
        $task->load('tags');

        return view('tasks.edit', compact('task', 'subjects', 'tags'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $user = $request->user();

        $data = $request->validate([
            'subject_id' => ['nullable','integer'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'status' => ['required','in:todo,doing,done'],
            'priority' => ['required','in:low,medium,high'],
            'due_at' => ['nullable','date'],
            'estimate_minutes' => ['nullable','integer','min:1','max:1440'],
            'tag_ids' => ['nullable','array'],
            'tag_ids.*' => ['integer'],
        ]);

        if (!empty($data['subject_id'])) {
            $owns = $user->subjects()->whereKey($data['subject_id'])->exists();
            abort_unless($owns, 403);
        }

        $task->fill([
            'subject_id' => $data['subject_id'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'priority' => $data['priority'],
            'due_at' => $data['due_at'] ?? null,
            'estimate_minutes' => $data['estimate_minutes'] ?? null,
        ]);

        $task->completed_at = ($data['status'] === 'done') ? ($task->completed_at ?? now()) : null;
        $task->save();

        $tagIds = $data['tag_ids'] ?? [];
        $valid = $user->tags()->whereIn('id', $tagIds)->pluck('id')->all();
        $task->tags()->sync($valid);

        return redirect()->route('tasks.show', $task)->with('status', 'Feladat frissítve.');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Feladat törölve.');
    }

    public function patchStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validate([
            'status' => ['required','in:todo,doing,done'],
        ]);

        $task->status = $data['status'];
        $task->completed_at = ($data['status'] === 'done') ? now() : null;
        $task->save();

        return back()->with('status', 'Státusz frissítve.');
    }

    public function dashboard()
{
    $tasks = auth()->user()
        ->tasks()
        ->orderBy('due_at')
        ->limit(5)
        ->get();

    return view('dashboard', compact('tasks'));
}

public function storeSubtask(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    Subtask::create([
        'task_id' => $task->id,
        'title' => $request->title,
        'is_done' => false,
    ]);

    return redirect()->route('tasks.show', $task);
}

public function destroySubtask(Task $task, Subtask $subtask)
{
    if ($subtask->task_id !== $task->id) {
        abort(404);
    }

    $subtask->delete();

    return redirect()->route('tasks.show', $task);
}

public function toggleSubtask(Task $task, Subtask $subtask)
{
    if ($subtask->task_id !== $task->id) {
        abort(404);
    }

    $subtask->update([
        'is_done' => !$subtask->is_done
    ]);

    return redirect()->route('tasks.show', $task);
}


}
