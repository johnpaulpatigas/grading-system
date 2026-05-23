<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function create(Request $request)
    {
        $students = Student::with('user')->get();
        $subjects = Subject::all();
        $selectedStudentId = $request->get('student_id');

        return view('enrollments.create', compact('students', 'subjects', 'selectedStudentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,id',
        ]);

        $student = Student::findOrFail($request->student_id);
        
        // Sync subjects (this will add new ones and remove ones not in the array)
        // Or use attach/detach if you prefer to only add.
        // Let's use sync for a "Manage Enrollment" feel.
        $student->subjects()->sync($request->subject_ids);

        return redirect()->route('students.show', $student->id)
            ->with('success', 'Enrollment updated successfully.');
    }
}
