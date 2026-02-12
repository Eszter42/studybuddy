<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        return Subject::where('user_id', $request->user()->id)->orderBy('name')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'teacher' => ['nullable','string','max:255'],
            'color' => ['nullable','string','max:32'],
        ]);

        $data['user_id'] = $request->user()->id;

        return response()->json(Subject::create($data), 201);
    }

    public function show(Request $request, Subject $subject)
    {
        $this->authorize('view', $subject);
        return $subject;
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
        return $subject;
    }

    public function destroy(Request $request, Subject $subject)
    {
        $this->authorize('delete', $subject);
        $subject->delete();
        return response()->noContent();
    }
}
