<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Task</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm text-gray-600">Title</label>
                        <input name="title" value="{{ old('title') }}" class="w-full rounded border-gray-300" required>
                        @error('title') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Description</label>
                        <textarea name="description" class="w-full rounded border-gray-300" rows="4">{{ old('description') }}</textarea>
                        @error('description') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-600">Priority</label>
                            <select name="priority" class="w-full rounded border-gray-300" required>
                                <option value="low" @selected(old('priority')==='low')>low</option>
                                <option value="medium" @selected(old('priority','medium')==='medium')>medium</option>
                                <option value="high" @selected(old('priority')==='high')>high</option>
                            </select>
                            @error('priority') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Subject (optional)</label>
                            <select name="subject_id" class="w-full rounded border-gray-300">
                                <option value="">—</option>
                                @foreach($subjects as $s)
                                    <option value="{{ $s->id }}" @selected(old('subject_id')==$s->id)>{{ $s->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Due at (optional)</label>
                            <input type="datetime-local" name="due_at" value="{{ old('due_at') }}" class="w-full rounded border-gray-300">
                            @error('due_at') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Estimate minutes (optional)</label>
                            <input type="number" name="estimate_minutes" value="{{ old('estimate_minutes') }}" class="w-full rounded border-gray-300" min="1" max="1440">
                            @error('estimate_minutes') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 rounded bg-indigo-600 text-white">Create</button>
                        <a href="{{ route('tasks.index') }}" class="px-4 py-2 rounded bg-gray-100 text-gray-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
