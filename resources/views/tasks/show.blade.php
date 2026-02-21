<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                {{ $task->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('tasks.edit', $task) }}"
                   class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-slate-200 text-sm border border-white/10">
                    Edit
                </a>
                <a href="{{ route('tasks.index') }}"
                   class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-slate-200 text-sm border border-white/10">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('ok'))
                <div class="glass-card border border-emerald-400/20 bg-emerald-500/10 text-emerald-100 p-3 rounded-xl">
                    {{ session('ok') }}
                </div>
            @endif

            <div class="glass-card p-6 space-y-3">
                <div class="text-sm text-slate-300 flex flex-wrap gap-2">
                    <span>Status: <b class="text-slate-100">{{ $task->status }}</b></span>
                    <span>Priority: <b class="text-slate-100">{{ $task->priority }}</b></span>
                    <span>Due: <b class="text-slate-100">{{ $task->due_at ? $task->due_at->format('Y-m-d H:i') : '—' }}</b></span>
                    <span>Estimate: <b class="text-slate-100">{{ $task->estimate_minutes ? $task->estimate_minutes.' min' : '—' }}</b></span>
                    @if($task->subject)
                        <span>Subject: <b class="text-slate-100">{{ $task->subject->name }}</b></span>
                    @endif
                </div>

                @if($task->description)
                    <div class="pt-2 whitespace-pre-line text-slate-200">
                        {{ $task->description }}
                    </div>
                @endif
            </div>

            <!-- Subtasks -->
            <div class="glass-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-slate-100">Subtasks</h3>
                </div>

                <form method="POST"
                      action="{{ route('tasks.subtasks.store', $task) }}"
                      class="flex gap-3 mb-4">
                    @csrf
                    <input name="title"
                           class="flex-1 rounded-xl bg-white/5 border border-white/10 text-slate-100 placeholder:text-slate-400 focus:border-white/20 focus:ring-0"
                           placeholder="New subtask..."
                           required>
                    <button class="px-4 py-2 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white text-sm shadow">
                        Add
                    </button>
                </form>

                @error('title')
                    <div class="text-sm text-rose-400 mb-3">{{ $message }}</div>
                @enderror

                <div class="space-y-3">
                    @forelse($task->subtasks as $st)
                        <div class="flex items-center justify-between border border-white/10 rounded-xl p-3 bg-white/5">
                            <div class="flex items-center gap-3 min-w-0">
                                <form method="POST"
                                      action="{{ route('tasks.subtasks.toggle', [$task, $st]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="w-6 h-6 rounded border border-white/20 flex items-center justify-center text-slate-100">
                                        @if($st->is_done) ✓ @endif
                                    </button>
                                </form>

                                <div class="min-w-0">
                                    <div class="truncate {{ $st->is_done ? 'line-through text-slate-400' : 'text-slate-200' }}">
                                        {{ $st->title }}
                                    </div>
                                </div>
                            </div>

                            <form method="POST"
                                  action="{{ route('tasks.subtasks.destroy', [$task, $st]) }}"
                                  onsubmit="return confirm('Delete subtask?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-slate-400">No subtasks yet.</div>
                    @endforelse
                </div>
            </div>

            <form method="POST"
                  action="{{ route('tasks.destroy', $task) }}"
                  onsubmit="return confirm('Delete this task?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white shadow">
                    Delete task
                </button>
            </form>

        </div>
    </div>
</x-app-layout>