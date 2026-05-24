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
        
        // Enforce Prerequisites and Capacity
        $subjectsToEnroll = Subject::whereIn('id', $request->subject_ids)->withCount('students')->get();
        $passedSubjects = $student->grades()->where('average', '>=', 75)->pluck('subject_id')->toArray();
        $missingPrerequisites = [];
        $fullSubjects = [];

        foreach ($subjectsToEnroll as $subject) {
            // Check Capacity (only if they are not already enrolled)
            if (!$student->subjects->contains($subject->id) && $subject->students_count >= $subject->max_students) {
                $fullSubjects[] = "{$subject->subject_code} (Max: {$subject->max_students})";
            }

            // Check Prerequisites
            $prerequisites = $subject->prerequisites;
            foreach ($prerequisites as $prereq) {
                if (!in_array($prereq->id, $passedSubjects)) {
                    $missingPrerequisites[] = "{$subject->subject_code} requires passing {$prereq->subject_code}";
                }
            }
        }

        $errorMessages = [];
        if (!empty($fullSubjects)) {
            $errorMessages[] = 'The following subjects are at full capacity: ' . implode(', ', $fullSubjects);
        }
        if (!empty($missingPrerequisites)) {
            $errorMessages[] = 'Missing prerequisites: ' . implode(', ', $missingPrerequisites);
        }

        if (!empty($errorMessages)) {
            return back()->with('error', 'Enrollment failed: ' . implode(' | ', $errorMessages));
        }

        $semester = $request->get('semester', '1st Semester');
        $academicYear = $request->get('academic_year', '2026');

        $syncData = [];
        foreach ($request->subject_ids as $id) {
            $syncData[$id] = [
                'semester' => $semester,
                'academic_year' => $academicYear
            ];
        }

        // We only want to sync for the CURRENT semester/year to avoid wiping history
        // First, get other enrollments to preserve them
        $otherEnrollments = $student->subjects()
            ->where(function($query) use ($semester, $academicYear) {
                $query->where('semester', '!=', $semester)
                      ->orWhere('academic_year', '!=', $academicYear);
            })
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => [
                    'semester' => $item->pivot->semester,
                    'academic_year' => $item->pivot->academic_year
                ]];
            })->toArray();

        $student->subjects()->sync($syncData + $otherEnrollments);

        return redirect()->route('students.show', $student->id)
            ->with('success', "Enrollment updated successfully for $semester AY $academicYear.");
    }
}
