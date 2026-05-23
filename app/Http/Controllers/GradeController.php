<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::all();
        $selectedSubjectId = $request->get('subject_id', $subjects->first()?->id);
        
        $students = Student::with(['user', 'grades' => function($query) use ($selectedSubjectId) {
            $query->where('subject_id', $selectedSubjectId);
        }])->get();

        return view('grading.index', compact('students', 'subjects', 'selectedSubjectId'));
    }

    public function encode(Student $student, Request $request)
    {
        $subjectId = $request->get('subject_id');
        $subject = Subject::findOrFail($subjectId);
        $grade = Grade::where('student_id', $student->id)->where('subject_id', $subjectId)->first();
        
        return view('grading.encode', compact('student', 'subject', 'grade'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:255',
        ]);

        $faculty = Auth::user()->faculty;
        if (!$faculty && Auth::user()->isAdmin()) {
            // For admin, we just pick the first faculty or handle accordingly
            $faculty = Faculty::first();
        }

        Grade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
            ],
            [
                'faculty_id' => $faculty->id,
                'grade' => $request->grade,
                'remarks' => $request->remarks,
            ]
        );

        return redirect()->route('grading.index', ['subject_id' => $request->subject_id])->with('success', 'Grade saved successfully.');
    }
}
