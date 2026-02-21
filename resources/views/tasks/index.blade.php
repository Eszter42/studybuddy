<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">Tasks</h2>
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white text-sm shadow">
                + New
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

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
                    x-data="{ open: false, selected: '{{ request('status') ?? '' }}' }" 
                    class="w-full sm:w-48 relative z-50"
                >
                    <label class="text-sm text-slate-300">Status</label>

                    <input type="hidden" name="status" x-model="selected">

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
                        <div @click="selected='todo'; open=false" class="px-4 py-2 hover:bg-white/10 cursor-pointer">
                            todo
                        </div>
                        <div @click="selected='doing'; open=false" class="px-4 py-2 hover:bg-white/10 cursor-pointer">
                            doing
                        </div>
                        <div @click="selected='done'; open=false" class="px-4 py-2 hover:bg-white/10 cursor-pointer">
                            done
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

            <div class="glass-card p-0 overflow-hidden">
                @forelse ($tasks as $task)
                    <div class="px-6 py-5 border-b border-white/10 hover:bg-white/5 transition flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="min-w-0">
                            <a class="font-semibold text-slate-100 hover:underline" href="{{ route('tasks.show', $task) }}">
                                {{ $task->title }}
                            </a>

                            <div class="text-sm text-slate-300 mt-1 flex flex-wrap gap-2">
                                <span>Status: <b class="text-slate-100">{{ $task->status }}</b></span>
                                <span>Priority: <b class="text-slate-100">{{ $task->priority }}</b></span>
                                <span>Due: <b class="text-slate-100">{{ $task->due_at ? $task->due_at->format('Y-m-d H:i') : '—' }}</b></span>
                                @if($task->subject)
                                    <span>Subject: <b class="text-slate-100">{{ $task->subject->name }}</b></span>
                                @endif
                                <span>Subtasks: <b class="text-slate-100">{{ $task->subtasks->count() }}</b></span>
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
                    <div class="p-6 text-slate-300">No tasks yet. Create one!</div>
                @endforelse
            </div>

            @if ($tasks->hasPages())
                <div class="mt-4 flex justify-center">
                    {{ $tasks->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>