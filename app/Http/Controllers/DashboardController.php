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
            
            // Calculate passing rate (assuming grade <= 3.0 is passing or based on remarks)
            $totalGrades = Grade::count();
            $passingGrades = Grade::where('grade', '>', 0)->where(function($q) {
                $q->where('grade', '<=', 3.0)->orWhere('remarks', 'Pass');
            })->count();
            $passingRate = $totalGrades > 0 ? ($passingGrades / $totalGrades) * 100 : 0;

            return view('admin.dashboard', compact('totalStudents', 'totalSubjects', 'totalFaculty', 'encodingProgress', 'passingRate'));
        } elseif ($user->isFaculty()) {
            return view('faculty.dashboard');
        } else {
            $student = $user->student;
            $grades = $student ? $student->grades()->with('subject')->get() : collect();
            $gpa = $grades->avg('grade');
            $unitsEarned = $grades->sum(fn($g) => $g->subject->units);
            
            return view('student.dashboard', compact('grades', 'gpa', 'unitsEarned'));
        }
    }

    public function reports()
    {
        return view('reports.index');
    }
}
