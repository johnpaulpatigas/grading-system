<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subject::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('subject_code', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        $subjects = $query->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_code' => 'required|string|max:50|unique:subjects',
            'description' => 'required|string|max:255',
            'units' => 'required|numeric|min:0.5',
            'max_students' => 'nullable|integer|min:1',
        ]);

        Subject::create([
            'subject_code' => $request->subject_code,
            'description' => $request->description,
            'units' => $request->units,
            'max_students' => $request->max_students ?? 40,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_code' => 'required|string|max:50|unique:subjects,subject_code,' . $subject->id,
            'description' => 'required|string|max:255',
            'units' => 'required|numeric|min:0.5',
            'max_students' => 'nullable|integer|min:1',
        ]);

        $subject->update([
            'subject_code' => $request->subject_code,
            'description' => $request->description,
            'units' => $request->units,
            'max_students' => $request->max_students ?? 40,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
