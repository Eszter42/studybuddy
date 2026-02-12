<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubjectController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $subjects = Subject::where('user_id', $request->user()->id)
            ->orderBy('name')
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'teacher' => ['nullable','string','max:255'],
            'color' => ['nullable','string','max:32'],
        ]);

        $data['user_id'] = $request->user()->id;

        Subject::create($data);

        return redirect()->route('subjects.index')->with('status', 'Tantárgy létrehozva.');
    }

    public function edit(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'teacher' => ['nullable','string','max:255'],
            'color' => ['nullable','string','max:32'],
        ]);

        $subject->update($data);

        return redirect()->route('subjects.index')->with('status', 'Tantárgy frissítve.');
    }

    public function destroy(Request $request, Subject $subject)
    {
        $this->authorize('delete', $subject);
        $subject->delete();

        return redirect()->route('subjects.index')->with('status', 'Tantárgy törölve.');
    }
}
