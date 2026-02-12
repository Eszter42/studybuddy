<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Subject</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('subjects.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm text-gray-600">Name</label>
                        <input name="name" value="{{ old('name') }}" class="w-full rounded border-gray-300" required>
                        @error('name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Teacher (optional)</label>
                        <input name="teacher" value="{{ old('teacher') }}" class="w-full rounded border-gray-300">
                        @error('teacher') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Color (optional)</label>
                        <input name="color" value="{{ old('color', '#6366f1') }}" class="w-full rounded border-gray-300" placeholder="#6366f1">
                        @error('color') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 rounded bg-indigo-600 text-white">Create</button>
                        <a href="{{ route('subjects.index') }}" class="px-4 py-2 rounded bg-gray-100 text-gray-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
