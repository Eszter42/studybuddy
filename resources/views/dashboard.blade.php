<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between min-h-[36px]">
        <h2 class="font-semibold text-xl text-slate-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div id="dashboard-clock" class="text-sm md:text-base text-slate-300 font-medium tracking-wide"></div>
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
                    <p class="text-slate-400">No tasks approaching deadline.</p>
                @endforelse
            </div>

            <div class="glass-card p-8">
                <h3 class="text-xl font-semibold tracking-wide mb-6 text-indigo-300">
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
                    <p class="text-slate-400">No high priority tasks.</p>
                @endforelse
            </div>

            <div class="glass-card p-8">
                <h3 class="text-xl font-semibold tracking-wide mb-6 text-indigo-300">
                    Random task
                </h3>

                <div class="flex items-center justify-center min-h-[180px]">
                    <button
                        id="random-task-button"
                        type="button"
                        class="px-6 py-3 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white text-sm font-medium shadow"
                    >
                        Pick random task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="random-task-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="glass-card w-full max-w-md p-8 relative">
            <button
                id="close-random-task-modal"
                type="button"
                class="absolute top-4 right-4 text-slate-300 hover:text-white text-xl leading-none"
            >
                ×
            </button>

            <h3 class="text-xl font-semibold tracking-wide mb-6 text-indigo-300">
                Your random task is:
            </h3>

            <div id="random-task-content" class="space-y-3">
                <div class="text-lg font-medium text-white" id="random-task-title"></div>
                <div class="text-sm text-slate-400" id="random-task-due"></div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clock = document.getElementById('dashboard-clock');
        const randomTaskButton = document.getElementById('random-task-button');
        const randomTaskModal = document.getElementById('random-task-modal');
        const closeRandomTaskModal = document.getElementById('close-random-task-modal');
        const randomTaskTitle = document.getElementById('random-task-title');
        const randomTaskDue = document.getElementById('random-task-due');

        const allTasks = @json(
            $allTasks->map(function ($task) {
                return [
                    'title' => $task->title,
                    'due_at' => optional($task->due_at)->format('Y-m-d') ?? '—',
                ];
            })->values()
        );

        function updateClock() {
            const now = new Date();

            const formatted = now.toLocaleString('en-GB', {
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            clock.textContent = formatted;
        }

        function openRandomTaskModal(task) {
            randomTaskTitle.textContent = task.title;
            randomTaskDue.textContent = 'Due: ' + task.due_at;
            randomTaskModal.classList.remove('hidden');
            randomTaskModal.classList.add('flex');
        }

        function closeModal() {
            randomTaskModal.classList.add('hidden');
            randomTaskModal.classList.remove('flex');
        }

        randomTaskButton.addEventListener('click', function () {
            if (allTasks.length === 0) {
                randomTaskTitle.textContent = 'No tasks available.';
                randomTaskDue.textContent = '';
                randomTaskModal.classList.remove('hidden');
                randomTaskModal.classList.add('flex');
                return;
            }

            const randomIndex = Math.floor(Math.random() * allTasks.length);
            const randomTask = allTasks[randomIndex];

            openRandomTaskModal(randomTask);
        });

        closeRandomTaskModal.addEventListener('click', closeModal);

        randomTaskModal.addEventListener('click', function (event) {
            if (event.target === randomTaskModal) {
                closeModal();
            }
        });

        updateClock();
        setInterval(updateClock, 1000);
    });
</script>
</x-app-layout>