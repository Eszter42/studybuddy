<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $task->title }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-2 rounded bg-gray-100 text-gray-900 text-sm">Edit</a>
                <a href="{{ route('tasks.index') }}" class="px-3 py-2 rounded bg-gray-900 text-white text-sm">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('ok'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded">
                    {{ session('ok') }}
                </div>
            @endif

            <div class="bg-white shadow rounded p-6 space-y-2">
                <div class="text-sm text-gray-500 flex flex-wrap gap-2">
                    <span>Status: <b>{{ $task->status }}</b></span>
                    <span>Priority: <b>{{ $task->priority }}</b></span>
                    <span>Due: <b>{{ $task->due_at ? $task->due_at->format('Y-m-d H:i') : '—' }}</b></span>
                    <span>Estimate: <b>{{ $task->estimate_minutes ? $task->estimate_minutes.' min' : '—' }}</b></span>
                    @if($task->subject)
                        <span>Subject: <b>{{ $task->subject->name }}</b></span>
                    @endif
                </div>

                @if($task->description)
                    <div class="pt-2 whitespace-pre-line">{{ $task->description }}</div>
                @endif
            </div>

            <!-- Subtasks -->
            <div class="bg-white shadow rounded p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Subtasks</h3>
                </div>

                <form method="POST" action="{{ route('tasks.subtasks.store', $task) }}" class="flex gap-2 mb-4">
                    @csrf
                    <input name="title" class="flex-1 rounded border-gray-300" placeholder="New subtask..." required>
                    <button class="px-4 py-2 rounded bg-indigo-600 text-white">Add</button>
                </form>
                @error('title') <div class="text-sm text-red-600 mb-3">{{ $message }}</div> @enderror

                <div class="space-y-2">
                    @forelse($task->subtasks as $st)
                        <div class="flex items-center justify-between border rounded p-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <form method="POST" action="{{ route('tasks.subtasks.toggle', [$task, $st]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="w-6 h-6 rounded border flex items-center justify-center">
                                        @if($st->is_done) ✓ @endif
                                    </button>
                                </form>

                                <div class="min-w-0">
                                    <div class="truncate {{ $st->is_done ? 'line-through text-gray-400' : '' }}">
                                        {{ $st->title }}
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('tasks.subtasks.destroy', [$task, $st]) }}"
                                  onsubmit="return confirm('Delete subtask?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded bg-red-600 text-white text-sm">Delete</button>
                            </form>
                        </div>
                    @empty
                        <div class="text-gray-500">No subtasks yet.</div>
                    @endforelse
                </div>
            </div>

            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 rounded bg-red-700 text-white">Delete task</button>
            </form>

        </div>
    </div>
</x-app-layout>
