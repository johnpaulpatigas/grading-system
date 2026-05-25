<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'student_id' => ['required', 'string', 'max:20'],
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

        // Find existing student record that hasn't been "claimed" yet
        $student = Student::where('student_id', $request->student_id)
            ->whereNull('user_id')
            ->first();

        if (!$student) {
            return back()->with('error', 'Invalid Student ID or the account has already been registered. Please contact the administrator.')->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // Link the user to the existing student record
        $student->update([
            'user_id' => $user->id,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'section' => $request->section,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
