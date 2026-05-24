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
            'prerequisite_ids' => 'nullable|array',
            'prerequisite_ids.*' => 'exists:subjects,id',
        ]);

        $subject = Subject::create([
            'subject_code' => $request->subject_code,
            'description' => $request->description,
            'units' => $request->units,
            'max_students' => $request->max_students ?? 40,
        ]);

        if ($request->has('prerequisite_ids')) {
            $subject->prerequisites()->sync($request->prerequisite_ids);
        }

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
            'prerequisite_ids' => 'nullable|array',
            'prerequisite_ids.*' => 'exists:subjects,id',
        ]);

        // Check for circular prerequisites
        if ($request->has('prerequisite_ids')) {
            foreach ($request->prerequisite_ids as $prereqId) {
                if ($this->wouldCreateLoop($subject->id, $prereqId)) {
                    $prereq = Subject::find($prereqId);
                    return back()->with('error', "Cannot add {$prereq->subject_code} as a prerequisite. It would create a circular dependency loop.")->withInput();
                }
            }
        }

        $subject->update([
            'subject_code' => $request->subject_code,
            'description' => $request->description,
            'units' => $request->units,
            'max_students' => $request->max_students ?? 40,
        ]);

        if ($request->has('prerequisite_ids')) {
            $subject->prerequisites()->sync($request->prerequisite_ids);
        }

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    private function wouldCreateLoop($subjectId, $prerequisiteId, $visited = [])
    {
        if ($subjectId == $prerequisiteId) return true;
        if (in_array($prerequisiteId, $visited)) return false;

        $visited[] = $prerequisiteId;
        $prereq = Subject::find($prerequisiteId);
        
        foreach ($prereq->prerequisites as $p) {
            if ($this->wouldCreateLoop($subjectId, $p->id, $visited)) {
                return true;
            }
        }

        return false;
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
