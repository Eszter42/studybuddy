<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            New Task
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-6">
                <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm text-slate-300">Title</label>
                        <input
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                            required
                        >
                        @error('title')
                            <div class="text-sm text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm text-slate-300">Description</label>
                        <textarea
                            name="description"
                            rows="4"
                            class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-sm text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-slate-300">Priority</label>
                            <select
                                name="priority"
                                class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                                required
                            >
                                <option value="low" @selected(old('priority')==='low')>low</option>
                                <option value="medium" @selected(old('priority','medium')==='medium')>medium</option>
                                <option value="high" @selected(old('priority')==='high')>high</option>
                            </select>
                            @error('priority')
                                <div class="text-sm text-rose-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm text-slate-300">Subject (optional)</label>
                            <select
                                name="subject_id"
                                class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                            >
                                <option value="">—</option>
                                @foreach($subjects as $s)
                                    <option value="{{ $s->id }}" @selected(old('subject_id')==$s->id)>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <div class="text-sm text-rose-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm text-slate-300">Due at (optional)</label>
                            <input
                                type="datetime-local"
                                name="due_at"
                                value="{{ old('due_at') }}"
                                class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                            >
                            @error('due_at')
                                <div class="text-sm text-rose-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm text-slate-300">Estimate minutes (optional)</label>
                            <input
                                type="number"
                                name="estimate_minutes"
                                value="{{ old('estimate_minutes') }}"
                                min="1"
                                max="1440"
                                class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                            >
                            @error('estimate_minutes')
                                <div class="text-sm text-rose-400">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button class="px-5 py-2 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white shadow">
                            Create
                        </button>
                        <a href="{{ route('tasks.index') }}"
                           class="px-5 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-slate-200 border border-white/10">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>