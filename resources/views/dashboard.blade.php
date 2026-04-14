<x-app-layout>
<x-slot name="header">
    <div class="flex items-center min-h-[36px]">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </div>
</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="glass-card p-8">
                <h3 class="text-xl font-semibold tracking-wide mb-6 text-indigo-300">
                    Approaching deadline
                </h3>

                @forelse ($tasks as $task)
                    <div class="py-4 border-b border-white/10 last:border-none">
                        <div class="text-lg font-medium text-white">
                            {{ $task->title }}
                        </div>
                        <div class="text-sm text-slate-400">
                            Due: {{ optional($task->due_at)->format('Y-m-d') ?? '—' }}
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400">Nincs feladat.</p>
                @endforelse
            </div>

            <div class="glass-card p-8">
                <h3 class="text-xl font-semibold tracking-wide mb-6 text-indigo-300 ">
                    High priority tasks
                </h3>

                @forelse ($highPriorityTasks as $task)
                    <div class="py-4 border-b border-white/10 last:border-none">
                        <div class="text-lg font-medium text-white">
                            {{ $task->title }}
                        </div>
                        <div class="text-sm text-slate-400">
                            Due: {{ optional($task->due_at)->format('Y-m-d') ?? '—' }}
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400">Nincs high priority feladat.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>