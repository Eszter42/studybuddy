<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-bold mb-4">Közelgő feladatok</h3>

                @forelse ($tasks as $task)
                    <div class="border-b py-2">
                        <div class="font-semibold">{{ $task->title }}</div>
                        <div class="text-sm text-gray-500">
                            Határidő: {{ optional($task->due_at)->format('Y-m-d') ?? '—' }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Nincs feladat 🎉</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
