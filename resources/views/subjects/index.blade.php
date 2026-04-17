<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                Subjects
            </h2>
            <a href="{{ route('subjects.create') }}"
               class="px-4 py-2 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white text-sm shadow">
                + New
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('ok'))
                <div class="glass-card border border-emerald-400/20 bg-emerald-500/10 text-emerald-100 p-3 rounded-xl">
                    {{ session('ok') }}
                </div>
            @endif

            <div class="glass-card p-0 overflow-hidden">
    @forelse($subjects as $s)
        <div class="px-6 py-5 border-b border-white/10 hover:bg-white/5 transition flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            
            <div class="min-w-0">
                <div class="font-semibold text-slate-100">
                    {{ $s->name }}
                </div>

                <div class="text-sm text-slate-300 mt-1 flex flex-wrap gap-2">
                    <span>Teacher: <b class="text-slate-100">{{ $s->teacher ?? '—' }}</b></span>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('subjects.edit', $s) }}"
                   class="px-3 py-2 rounded-xl bg-white/10 hover:bg-white/15 text-white text-sm border border-white/10">
                    Edit
                </a>

                <form method="POST"
                      action="{{ route('subjects.destroy', $s) }}"
                      onsubmit="return confirm('Delete subject?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-sm">
                        Delete
                    </button>
                </form>
            </div>

        </div>
    @empty
        <div class="p-6 text-slate-300">
            No subjects yet.
        </div>
    @endforelse
</div>

        </div>
    </div>
</x-app-layout>