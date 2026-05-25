<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('course') && $request->course !== 'All Courses') {
            $query->where('course', $request->course);
        }

        if ($request->filled('year_level') && $request->year_level !== 'Year Level') {
            $query->where('year_level', $request->year_level);
        }

        if ($request->filled('section') && $request->section !== 'All Sections') {
            $query->where('section', $request->section);
        }

        $students = $query->get();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|size:8|unique:students',
            'course' => ['required', 'string', Rule::in(Student::COURSES)],
            'year_level' => ['required', 'string', Rule::in(array_keys(Student::YEAR_LEVELS))],
            'section' => ['required', 'string', function ($attribute, $value, $fail) use ($request) {
                $yearLevel = $request->year_level;
                if (!isset(Student::YEAR_LEVELS[$yearLevel])) return;
                $num = Student::YEAR_LEVELS[$yearLevel];
                $validSections = array_map(fn($s) => $num . $s, Student::SECTIONS);
                if (!in_array($value, $validSections)) {
                    $fail("The selected section is invalid for the chosen year level.");
                }
            }],
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->student_id),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'section' => $request->section,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|size:8|unique:students,student_id,' . $student->id,
            'course' => ['required', 'string', Rule::in(Student::COURSES)],
            'year_level' => ['required', 'string', Rule::in(array_keys(Student::YEAR_LEVELS))],
            'section' => ['required', 'string', function ($attribute, $value, $fail) use ($request) {
                $yearLevel = $request->year_level;
                if (!isset(Student::YEAR_LEVELS[$yearLevel])) return;
                $num = Student::YEAR_LEVELS[$yearLevel];
                $validSections = array_map(fn($s) => $num . $s, Student::SECTIONS);
                if (!in_array($value, $validSections)) {
                    $fail("The selected section is invalid for the chosen year level.");
                }
            }],
        ]);

        $student->user->update([
            'name' => $request->name,
        ]);

        $student->update([
            'student_id' => $request->student_id,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'section' => $request->section,
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->user->delete(); // This will also delete student due to cascade
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
