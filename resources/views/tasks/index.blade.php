<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="px-3 py-2 rounded bg-indigo-600 text-white text-sm">+ New</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('ok'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded">
                    {{ session('ok') }}
                </div>
            @endif

            <form method="GET" class="bg-white shadow rounded p-4 flex flex-col sm:flex-row gap-3 sm:items-end">
                <div class="flex-1">
                    <label class="text-sm text-gray-600">Search</label>
                    <input name="q" value="{{ request('q') }}" class="w-full rounded border-gray-300" placeholder="title / description">
                </div>

                <div class="w-full sm:w-48">
                    <label class="text-sm text-gray-600">Status</label>
                    <select name="status" class="w-full rounded border-gray-300">
                        <option value="">All</option>
                        <option value="todo"  @selected(request('status')==='todo')>todo</option>
                        <option value="doing" @selected(request('status')==='doing')>doing</option>
                        <option value="done"  @selected(request('status')==='done')>done</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button class="px-4 py-2 rounded bg-gray-900 text-white text-sm">Filter</button>
                    <a href="{{ route('tasks.index') }}" class="px-4 py-2 rounded bg-gray-100 text-gray-900 text-sm">Reset</a>
                </div>
            </form>

            <div class="bg-white shadow rounded overflow-hidden">
                @forelse ($tasks as $task)
                    <div class="p-4 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="min-w-0">
                            <a class="font-semibold hover:underline" href="{{ route('tasks.show', $task) }}">
                                {{ $task->title }}
                            </a>

                            <div class="text-sm text-gray-500 mt-1 flex flex-wrap gap-2">
                                <span>Status: <b>{{ $task->status }}</b></span>
                                <span>Priority: <b>{{ $task->priority }}</b></span>
                                <span>Due: <b>{{ $task->due_at ? $task->due_at->format('Y-m-d H:i') : '—' }}</b></span>
                                @if($task->subject)
                                    <span>Subject: <b>{{ $task->subject->name }}</b></span>
                                @endif
                                <span>Subtasks: <b>{{ $task->subtasks->count() }}</b></span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-2 rounded bg-gray-100 text-gray-900 text-sm">Edit</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded bg-red-600 text-white text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-gray-600">No tasks yet. Create one!</div>
                @endforelse
            </div>

            <div>
                {{ $tasks->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
