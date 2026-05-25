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
            'year_level' => ['required', 'string', 'max:20'],
            'section' => ['required', 'string', 'max:20'],
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
