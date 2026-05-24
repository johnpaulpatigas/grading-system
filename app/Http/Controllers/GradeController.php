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
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $subjects = Subject::all();
        } else {
            $subjects = $user->faculty->subjects;
        }

        if ($subjects->isEmpty()) {
            return view('grading.index', [
                'students' => collect(),
                'subjects' => collect(),
                'selectedSubjectId' => null
            ]);
        }

        $selectedSubjectId = $request->get('subject_id', $subjects->first()->id);
        
        $students = Student::whereHas('subjects', function($query) use ($selectedSubjectId) {
            $query->where('subject_id', $selectedSubjectId);
        })->with(['user', 'grades' => function($query) use ($selectedSubjectId) {
            $query->where('subject_id', $selectedSubjectId);
        }])->get();

        return view('grading.index', compact('students', 'subjects', 'selectedSubjectId'));
    }

    public function encode(Student $student, Request $request)
    {
        $subjectId = $request->get('subject_id');
        if (!$subjectId) {
            return redirect()->route('grading.index')->with('error', 'Please select a subject first.');
        }

        $subject = Subject::findOrFail($subjectId);

        if (!Auth::user()->isAdmin() && !Auth::user()->faculty->subjects->contains($subjectId)) {
            return redirect()->route('grading.index')->with('error', 'You are not assigned to this subject.');
        }

        $grade = Grade::where('student_id', $student->id)
            ->where('subject_id', $subjectId)
            ->where('semester', $request->get('semester', '1st Semester'))
            ->where('academic_year', $request->get('academic_year', '2026'))
            ->first();
        
        if ($grade && $grade->status === 'Final' && !Auth::user()->isAdmin()) {
            return redirect()->route('grading.index', ['subject_id' => $subjectId])->with('error', 'Grades for this subject have been finalized and cannot be edited.');
        }

        $faculties = Auth::user()->isAdmin() ? Faculty::with('user')->get() : collect();

        return view('grading.encode', compact('student', 'subject', 'grade', 'faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'faculty_id' => 'nullable|exists:faculties,id',
            'prelim' => 'nullable|numeric|min:0|max:100',
            'midterm' => 'nullable|numeric|min:0|max:100',
            'final' => 'nullable|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:255',
        ]);

        $facultyId = $request->faculty_id;
        
        if (!Auth::user()->isAdmin()) {
            $facultyId = Auth::user()->faculty?->id;
        }

        if (!$facultyId && Auth::user()->isAdmin()) {
            // If admin and no faculty selected, we can fallback to the first one but ideally we'd want them to pick
            // For now, let's keep it as is but the view change will help
            $facultyId = Faculty::first()?->id;
        }

        if (!$facultyId) {
            return back()->with('error', 'No faculty record found to associate with this grade. Please create a faculty record first.');
        }

        $subject = Subject::findOrFail($request->subject_id);
        $student = Student::findOrFail($request->student_id);

        // Validate that Faculty is assigned to this Subject
        $isAssigned = $subject->faculties()->where('faculty_id', $facultyId)->exists();
        if (!$isAssigned) {
            $facultyName = Faculty::find($facultyId)?->user?->name ?? 'Selected Faculty';
            return back()->with('error', "{$facultyName} is not assigned to teach {$subject->subject_code}.");
        }

        // Enforce Prerequisites check before saving grade
        $passedSubjects = $student->grades()->where('average', '>=', 75)->pluck('subject_id')->toArray();
        foreach ($subject->prerequisites as $prereq) {
            if (!in_array($prereq->id, $passedSubjects)) {
                return back()->with('error', "Cannot save grade. Student has not passed prerequisite: {$prereq->subject_code}");
            }
        }

        $semester = $request->get('semester', '1st Semester');
        $academicYear = $request->get('academic_year', '2026');

        $existingGrade = Grade::where([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'semester' => $semester,
            'academic_year' => $academicYear
        ])->first();
        
        if ($existingGrade && $existingGrade->status === 'Final' && !Auth::user()->isAdmin()) {
            return back()->with('error', 'Grades for this subject and term have been finalized and cannot be edited.');
        }

        $gradeRecord = Grade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'semester' => $semester,
                'academic_year' => $academicYear,
            ],
            [
                'faculty_id' => $facultyId,
                'prelim' => $request->prelim,
                'midterm' => $request->midterm,
                'final' => $request->final,
                'remarks' => $request->remarks,
            ]
        );

        if ($gradeRecord->average !== null) {
            $gradeRecord->student->refreshAcademicStatus();
        }

        return redirect()->route('grading.index', ['subject_id' => $request->subject_id])->with('success', 'Grade saved.');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'nullable|string',
            'academic_year' => 'nullable|string',
        ]);

        $subjectId = $request->subject_id;
        $semester = $request->get('semester', '1st Semester');
        $academicYear = $request->get('academic_year', '2026');
        
        if (!Auth::user()->isAdmin()) {
            $facultyId = Auth::user()->faculty?->id;
            if (!$facultyId || !Auth::user()->faculty->subjects->contains($subjectId)) {
                return back()->with('error', 'Unauthorized. You are not assigned to this subject.');
            }
        }

        // Check for incomplete grades before finalizing
        $incompleteGrades = Grade::where('subject_id', $subjectId)
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->where('remarks', 'In Progress')
            ->count();

        if ($incompleteGrades > 0) {
            return back()->with('error', "Cannot finalize. There are $incompleteGrades students with incomplete grade components.");
        }

        $query = Grade::where('subject_id', $subjectId)
            ->where('semester', $semester)
            ->where('academic_year', $academicYear);
            
        if (!Auth::user()->isAdmin()) {
            $query->where('faculty_id', $facultyId);
        }

        $query->update(['status' => 'Final']);

        return redirect()->route('grading.index', ['subject_id' => $subjectId])->with('success', 'Grades have been finalized successfully.');
    }
}
