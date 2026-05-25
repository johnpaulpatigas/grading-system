<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Faculty::with('user');

        if ($request->filled('department') && $request->department !== 'All Department') {
            $query->where('department', $request->department);
        }

        $faculties = $query->get();
        return view('faculty.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = \App\Models\Subject::all();
        return view('faculty.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'employee_id' => 'required|string|size:12|unique:faculties',
            'department' => 'required|string|max:100',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => 'faculty',
        ]);

        $faculty = Faculty::create([
            'user_id' => $user->id,
            'employee_id' => $request->employee_id,
            'department' => $request->department,
        ]);

        if ($request->has('subject_ids')) {
            $faculty->subjects()->sync($request->subject_ids);
        }

        return redirect()->route('faculty.index')->with('success', 'Faculty created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        return view('faculty.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty)
    {
        $subjects = \App\Models\Subject::all();
        return view('faculty.edit', compact('faculty', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $faculty->user_id,
            'employee_id' => 'required|string|size:12|unique:faculties,employee_id,' . $faculty->id,
            'department' => 'required|string|max:100',
            'subject_ids' => 'nullable|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $faculty->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $faculty->update([
            'employee_id' => $request->employee_id,
            'department' => $request->department,
        ]);

        if ($request->has('subject_ids')) {
            $faculty->subjects()->sync($request->subject_ids);
        } else {
            $faculty->subjects()->detach();
        }

        return redirect()->route('faculty.index')->with('success', 'Faculty updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->user->delete();
        return redirect()->route('faculty.index')->with('success', 'Faculty deleted successfully.');
    }
}
