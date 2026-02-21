<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            New Subject
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-6">
                <form method="POST" action="{{ route('subjects.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm text-slate-300">Name</label>
                        <input
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                            required
                        >
                        @error('name')
                            <div class="text-sm text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm text-slate-300">Teacher (optional)</label>
                        <input
                            name="teacher"
                            value="{{ old('teacher') }}"
                            class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                        >
                        @error('teacher')
                            <div class="text-sm text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm text-slate-300">Color (optional)</label>
                        <input
                            name="color"
                            value="{{ old('color', '#6366f1') }}"
                            placeholder="#6366f1"
                            class="w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                        >
                        @error('color')
                            <div class="text-sm text-rose-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button class="px-5 py-2 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white shadow">
                            Create
                        </button>

                        <a href="{{ route('subjects.index') }}"
                           class="px-5 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-slate-200 border border-white/10">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>