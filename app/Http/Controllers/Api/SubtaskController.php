<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubtaskRequest;
use App\Http\Requests\UpdateSubtaskRequest;
use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    // POST /api/tasks/{task}/subtasks
    public function store(StoreSubtaskRequest $request, Task $task)
    {
        // Task ownership
        $this->authorize('update', $task);

        $subtask = $task->subtasks()->create([
            'title' => $request->string('title'),
            'is_done' => (bool) $request->input('is_done', false),
        ]);

        return response()->json($subtask, 201);
    }

    // PATCH /api/subtasks/{subtask}
    public function update(UpdateSubtaskRequest $request, Subtask $subtask)
    {
        // kell a task kapcsolat a policy-hoz
        $subtask->loadMissing('task');

        $this->authorize('update', $subtask);

        if ($request->has('title')) {
            $subtask->title = $request->string('title');
        }
        if ($request->has('is_done')) {
            $subtask->is_done = (bool) $request->boolean('is_done');
        }

        $subtask->save();

        return $subtask->fresh();
    }

    // DELETE /api/subtasks/{subtask}
    public function destroy(Request $request, Subtask $subtask)
    {
        $subtask->loadMissing('task');

        $this->authorize('delete', $subtask);

        $subtask->delete();

        return response()->noContent();
    }
}
