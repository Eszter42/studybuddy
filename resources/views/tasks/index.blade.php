<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white text-sm shadow">
                + New
            </a>
        </div>
    </x-slot>

    @php
        $taskCollection = method_exists($tasks, 'getCollection') ? $tasks->getCollection() : $tasks;
        $activeTasks = $taskCollection->filter(fn ($task) => $task->status !== 'done');
        $completedTasks = $taskCollection->filter(fn ($task) => $task->status === 'done');
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('ok'))
                <div class="glass-card border border-emerald-400/20 bg-emerald-500/10 text-emerald-100 p-3 rounded-xl">
                    {{ session('ok') }}
                </div>
            @endif

            <form method="GET" class="glass-card relative z-10 p-4 flex flex-col sm:flex-row gap-3 sm:items-end">
                <div class="flex-1">
                    <label class="text-sm text-slate-300">Search</label>
                    <input
                        name="q"
                        value="{{ request('q') }}"
                        class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 placeholder:text-slate-400 focus:border-white/20 focus:ring-0"
                        placeholder="title / description"
                    >
                </div>

                <div
                    x-data="{ open: false, selected: '{{ request('priority') ?? '' }}' }"
                    class="w-full sm:w-48 relative z-50"
                >
                    <label class="text-sm text-slate-300">Priority</label>

                    <input type="hidden" name="priority" x-model="selected">

                    <button
                        type="button"
                        @click="open = !open"
                        class="w-full mt-1 px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-100 flex justify-between items-center"
                    >
                        <span x-text="selected === '' ? 'All' : selected"></span>
                        <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute z-[100] mt-2 w-full rounded-2xl bg-slate-900/95 backdrop-blur-xl border border-white/10 shadow-xl overflow-hidden"
                        style="display: none;"
                    >
                        <div @click="selected=''; open=false" class="px-4 py-2 hover:bg-white/10 cursor-pointer">
                            All
                        </div>
                        <div @click="selected='low'; open=false" class="px-4 py-2 hover:bg-white/10 cursor-pointer">
                            low
                        </div>
                        <div @click="selected='medium'; open=false" class="px-4 py-2 hover:bg-white/10 cursor-pointer">
                            medium
                        </div>
                        <div @click="selected='high'; open=false" class="px-4 py-2 hover:bg-white/10 cursor-pointer">
                            high
                        </div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-white text-sm border border-white/10">
                        Filter
                    </button>
                    <a href="{{ route('tasks.index') }}" class="px-4 py-2 rounded-xl bg-transparent hover:bg-white/10 text-slate-200 text-sm border border-white/10">
                        Reset
                    </a>
                </div>
            </form>

            @if ($activeTasks->isEmpty() && $completedTasks->isEmpty())
                <div class="glass-card p-6 text-slate-300">No tasks yet. Create one!</div>
            @else
                <div class="space-y-6">
                    <div>
                        <div class="glass-card px-5 py-4 mb-3">
                            <h3 class="text-lg font-semibold text-slate-100">Ongoing Tasks</h3>
                        </div>

                        <div class="glass-card p-0 overflow-hidden">
                            @forelse ($activeTasks as $task)
                                <div class="px-6 py-5 border-b border-white/10 hover:bg-white/5 transition flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="min-w-0 flex items-start gap-4">
                                        <form method="POST" action="{{ route('tasks.patchStatus', $task) }}" class="pt-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="done">
                                            <button
                                                type="submit"
                                                class="h-7 w-7 rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 flex items-center justify-center text-white"
                                                title="Mark as complete"
                                            >
                                            </button>
                                        </form>

                                        <div class="min-w-0">
                                            <a
                                                class="font-semibold hover:underline text-slate-100"
                                                href="{{ route('tasks.show', $task) }}"
                                            >
                                                {{ $task->title }}
                                            </a>

                                            <div class="text-sm mt-1 flex flex-wrap gap-2 text-slate-300">
                                                <span>Priority: <b class="text-slate-100">{{ $task->priority }}</b></span>
                                                <span>Due: <b class="text-slate-100">{{ $task->due_at ? $task->due_at->format('Y-m-d H:i') : '—' }}</b></span>
                                                @if($task->subject)
                                                    <span>Subject: <b class="text-slate-100">{{ $task->subject->name }}</b></span>
                                                @endif
                                                <span>Subtasks: <b class="text-slate-100">{{ $task->subtasks->count() }}</b></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-2">
                                        <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-white text-sm border border-white/10">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-slate-300">No current tasks.</div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <div class="glass-card px-5 py-4 mb-3">
                            <h3 class="text-lg font-semibold text-slate-300">Completed Tasks</h3>
                        </div>

                        <div class="glass-card p-0 overflow-hidden">
                            @forelse ($completedTasks as $task)
                                <div class="px-6 py-5 border-b border-white/10 hover:bg-white/5 transition flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 opacity-70">
                                    <div class="min-w-0 flex items-start gap-4">
                                        <form method="POST" action="{{ route('tasks.patchStatus', $task) }}" class="pt-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="todo">
                                            <button
                                                type="submit"
                                                class="h-7 w-7 rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 flex items-center justify-center text-white"
                                                title="Mark as incomplete"
                                            >
                                                ✓
                                            </button>
                                        </form>

                                        <div class="min-w-0">
                                            <a
                                                class="font-semibold hover:underline text-slate-400 line-through"
                                                href="{{ route('tasks.show', $task) }}"
                                            >
                                                {{ $task->title }}
                                            </a>

                                            <div class="text-sm mt-1 flex flex-wrap gap-2 text-slate-400 line-through">
                                                <span>Priority: <b class="text-slate-400">{{ $task->priority }}</b></span>
                                                <span>Due: <b class="text-slate-400">{{ $task->due_at ? $task->due_at->format('Y-m-d H:i') : '—' }}</b></span>
                                                @if($task->subject)
                                                    <span>Subject: <b class="text-slate-400">{{ $task->subject->name }}</b></span>
                                                @endif
                                                <span>Subtasks: <b class="text-slate-400">{{ $task->subtasks->count() }}</b></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-2">
                                        <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-white text-sm border border-white/10">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-slate-300">No completed tasks.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            @if ($tasks->hasPages())
                <div class="mt-4 flex justify-center">
                    {{ $tasks->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>