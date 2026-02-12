<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Subjects</h2>
            <a href="{{ route('subjects.create') }}" class="px-3 py-2 rounded bg-indigo-600 text-white text-sm">+ New</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('ok'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded">
                    {{ session('ok') }}
                </div>
            @endif

            <div class="bg-white shadow rounded overflow-hidden">
                @forelse($subjects as $s)
                    <div class="p-4 border-b flex items-center justify-between">
                        <div>
                            <div class="font-semibold flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full" style="background: {{ $s->color ?? '#6366f1' }}"></span>
                                {{ $s->name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Teacher: {{ $s->teacher ?? '—' }}
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('subjects.edit', $s) }}" class="px-3 py-2 rounded bg-gray-100 text-gray-900 text-sm">Edit</a>
                            <form method="POST" action="{{ route('subjects.destroy', $s) }}" onsubmit="return confirm('Delete subject?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded bg-red-600 text-white text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-gray-600">No subjects yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
