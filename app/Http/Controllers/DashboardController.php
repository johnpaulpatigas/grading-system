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

            // Calculate passing rate (assuming grade <= 3.0 is passing)
            $totalGradesCount = Grade::count();
            $passingGradesCount = Grade::where('grade', '>', 0)->where('grade', '<=', 3.0)->count();
            $passingRate = $totalGradesCount > 0 ? ($passingGradesCount / $totalGradesCount) * 100 : 0;

            // Grade Distribution for Donut Chart
            $distribution = [
                'passing' => Grade::where('grade', '>', 0)->where('grade', '<=', 3.0)->count(),
                'conditional' => Grade::where('grade', '>', 3.0)->where('grade', '<=', 4.0)->count(),
                'failing' => Grade::where('grade', '>', 4.0)->orWhere('remarks', 'Fail')->count(),
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
        }
 elseif ($user->isFaculty()) {
            return view('faculty.dashboard');
        } else {
            $student = $user->student;
            $grades = $student ? $student->grades()->with('subject')->get() : collect();
            $gpa = $grades->avg('grade');
            $unitsEarned = $grades->sum(fn($g) => $g->subject->units);
            
            // Calculate Rank
            $allStudentAverages = Student::with('grades')->get()->map(function($s) {
                return [
                    'id' => $s->id,
                    'avg' => $s->grades->avg('grade') ?? 5.0 // Use 5.0 for no grades
                ];
            })->sortBy('avg')->values();
            
            $rank = $student ? $allStudentAverages->search(fn($item) => $item['id'] === $student->id) + 1 : '-';
            $ordinal = $rank !== '-' ? match($rank % 10) { 1 => 'st', 2 => 'nd', 3 => 'rd', default => 'th' } : '';
            if ($rank > 10 && $rank < 20) $ordinal = 'th';

            return view('student.dashboard', compact('grades', 'gpa', 'unitsEarned', 'rank', 'ordinal'));
        }
    }

    public function reports()
    {
        return view('reports.index');
    }
}
