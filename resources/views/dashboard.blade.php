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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative">
                <div class="overflow-hidden">
                    <div id="dashboard-carousel-track" class="flex transition-transform duration-700 ease-in-out">
                        <div class="w-full shrink-0">
                            <div class="glass-card p-8 min-h-[420px]">
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
                        </div>

                        <div class="w-full shrink-0">
                            <div class="glass-card p-8 min-h-[420px]">
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
                        </div>

                        <div class="w-full shrink-0">
                            <div class="glass-card p-8 min-h-[420px]">
                                <h3 class="text-xl font-semibold tracking-wide mb-6 text-indigo-300">
                                    Random task
                                </h3>

                                <div class="flex items-center justify-center min-h-[300px]">
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

                        <div class="w-full shrink-0">
                            <div class="glass-card p-8 min-h-[420px]">
                                <h3 class="text-xl font-semibold tracking-wide mb-6 text-indigo-300">
                                    Completed tasks (Good job!)
                                </h3>

                                @forelse ($completedTasks as $task)
                                    <div class="py-4 border-b border-white/10 last:border-none">
                                        <div class="text-lg font-medium text-white line-through">
                                            {{ $task->title }}
                                        </div>
                                        <div class="text-sm text-slate-400">
                                            Due: -
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-slate-400">No completed tasks.</p>
                                @endforelse
                            </div>
                        </div>                        

                        <div class="w-full shrink-0">
                            <div class="glass-card p-8 min-h-[420px]">
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
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-3 mt-6">
                    <button
                        type="button"
                        class="dashboard-dot h-3 w-3 rounded-full bg-white/30 transition-all duration-300"
                        data-slide="0"
                        aria-label="Go to slide 1"
                    ></button>
                    <button
                        type="button"
                        class="dashboard-dot h-3 w-3 rounded-full bg-white/30 transition-all duration-300"
                        data-slide="1"
                        aria-label="Go to slide 2"
                    ></button>
                    <button
                        type="button"
                        class="dashboard-dot h-3 w-3 rounded-full bg-white/30 transition-all duration-300"
                        data-slide="2"
                        aria-label="Go to slide 3"
                    ></button>
                    <button
                        type="button"
                        class="dashboard-dot h-3 w-3 rounded-full bg-white/30 transition-all duration-300"
                        data-slide="3"
                        aria-label="Go to slide 4"
                    ></button>
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
        const carouselTrack = document.getElementById('dashboard-carousel-track');
        const dots = document.querySelectorAll('.dashboard-dot');
        const totalSlides = dots.length;

        let currentSlide = 0;
        let autoSlide;
        let isResetting = false;

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

        function updateDots() {
            dots.forEach(function (dot, index) {
                if (index === currentSlide) {
                    dot.classList.remove('bg-white/30');
                    dot.classList.add('bg-indigo-300', 'scale-125');
                } else {
                    dot.classList.remove('bg-indigo-300', 'scale-125');
                    dot.classList.add('bg-white/30');
                }
            });
        }

        function goToSlide(index, withTransition = true) {
            if (withTransition) {
                carouselTrack.classList.add('transition-transform', 'duration-700', 'ease-in-out');
            } else {
                carouselTrack.classList.remove('transition-transform', 'duration-700', 'ease-in-out');
            }

            carouselTrack.style.transform = 'translateX(-' + (index * 100) + '%)';
        }

        function goToRealSlide(index) {
            currentSlide = index;
            updateDots();
            goToSlide(index, true);
        }

        function startAutoSlide() {
            autoSlide = setInterval(function () {
                if (isResetting) {
                    return;
                }

                if (currentSlide === totalSlides - 1) {
                    goToSlide(totalSlides, true);
                } else {
                    goToRealSlide(currentSlide + 1);
                }
            }, 6000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlide);
            startAutoSlide();
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

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                const slideIndex = Number(dot.getAttribute('data-slide'));
                currentSlide = slideIndex;
                updateDots();
                goToSlide(slideIndex, true);
                resetAutoSlide();
            });
        });

        carouselTrack.addEventListener('transitionend', function () {
            if (carouselTrack.style.transform === 'translateX(-' + (totalSlides * 100) + '%)') {
                isResetting = true;
                currentSlide = 0;
                updateDots();
                goToSlide(0, false);

                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        isResetting = false;
                    });
                });
            }
        });

        updateClock();
        setInterval(updateClock, 1000);

        goToRealSlide(0);
        startAutoSlide();
    });
</script>
</x-app-layout>