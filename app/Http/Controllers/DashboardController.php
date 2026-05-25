<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Faculty;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $totalStudents = Student::count();
            $totalSubjects = Subject::count();
            $totalFaculty = Faculty::count();

            // Calculate encoding progress
            $expectedGrades = $totalStudents * $totalSubjects;
            $actualGrades = Grade::count();
            $encodingProgress = $expectedGrades > 0 ? ($actualGrades / $expectedGrades) * 100 : 0;

            // Calculate passing rate (assuming average >= 75 is passing)
            $totalGradesCount = Grade::count();
            $passingGradesCount = Grade::where('average', '>=', 75)->count();
            $passingRate = $totalGradesCount > 0 ? ($passingGradesCount / $totalGradesCount) * 100 : 0;

            // Grade Distribution for Donut Chart
            $distribution = [
                'passing' => Grade::where('average', '>=', 75)->count(),
                'conditional' => Grade::where('average', '>=', 70)->where('average', '<', 75)->count(),
                'failing' => Grade::where('average', '<', 70)->orWhere('remarks', 'Fail')->count(),
            ];
            $distTotal = array_sum($distribution);
            $distPercents = [
                'passing' => $distTotal > 0 ? round(($distribution['passing'] / $distTotal) * 100) : 0,
                'conditional' => $distTotal > 0 ? round(($distribution['conditional'] / $distTotal) * 100) : 0,
                'failing' => $distTotal > 0 ? round(($distribution['failing'] / $distTotal) * 100) : 0,
            ];

            // Daily Progress (Last 7 days for line chart)
            $dailyProgress = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $dailyProgress[] = Grade::whereDate('created_at', $date)->count();
            }

            return view('admin.dashboard', compact(
                'totalStudents', 'totalSubjects', 'totalFaculty', 
                'encodingProgress', 'passingRate', 'distPercents', 
                'distTotal', 'dailyProgress'
            ));
        } elseif ($user->isFaculty()) {
            $faculty = $user->faculty;
            $subjects = $faculty ? $faculty->subjects()->with('students')->get() : collect();
            
            $totalSubjects = $subjects->count();
            $totalUnits = $subjects->sum('units');
            
            $totalStudents = $subjects->sum(fn($s) => $s->students->count());
            
            $expectedGrades = $totalStudents;
            $actualGrades = Grade::where('faculty_id', $faculty?->id)->count();
            $gradingProgress = $expectedGrades > 0 ? ($actualGrades / $expectedGrades) * 100 : 0;

            return view('faculty.dashboard', compact('subjects', 'totalSubjects', 'totalUnits', 'totalStudents', 'gradingProgress', 'actualGrades', 'expectedGrades'));
        } else {
            $student = $user->student;
            $grades = $student ? $student->grades()->with('subject')->get() : collect();
            
            // Weighted GPA Calculation: sum(average * units) / sum(units)
            $totalWeightedPoints = $grades->sum(fn($g) => $g->average * $g->subject->units);
            $totalUnits = $grades->sum(fn($g) => $g->subject->units);
            $gpa = $totalUnits > 0 ? $totalWeightedPoints / $totalUnits : 0;
            
            $unitsEarned = $totalUnits;
            
            // Calculate Rank
            $allStudentAverages = Student::with(['grades.subject'])->get()->map(function($s) {
                $sGrades = $s->grades;
                $twp = $sGrades->sum(fn($g) => $g->average * $g->subject->units);
                $tu = $sGrades->sum(fn($g) => $g->subject->units);
                return [
                    'id' => $s->id,
                    'avg' => $tu > 0 ? $twp / $tu : 5.0
                ];
            })->sortBy('avg')->values();
            
            $rank = $student ? $allStudentAverages->search(fn($item) => $item['id'] === $student->id) + 1 : '-';
            $ordinal = '';
            if (is_numeric($rank)) {
                $ordinal = match($rank % 10) { 1 => 'st', 2 => 'nd', 3 => 'rd', default => 'th' };
                if ($rank > 10 && $rank < 20) $ordinal = 'th';
            }

            return view('student.dashboard', compact('grades', 'gpa', 'unitsEarned', 'rank', 'ordinal'));
        }
    }

    public function reports(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isFaculty()) {
            $studentId = $request->get('student_id');
            if ($studentId) {
                $student = Student::with(['user', 'grades.subject'])->findOrFail($studentId);
                return view('reports.index', compact('student'));
            }
            
            $students = Student::with('user')->get();
            return view('reports.selection', compact('students'));
        }

        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Student profile not found. Please contact the administrator.');
        }

        $student->load(['grades.subject']);
        return view('reports.index', compact('student'));
    }
}
