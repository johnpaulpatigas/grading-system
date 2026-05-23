<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginField = $request->has('student_id') ? 'student_id' : 'email';
        
        $request->validate([
            $loginField => ['required'],
            'password' => ['required'],
        ]);

        $credentials = $request->only($loginField, 'password');

        if ($loginField === 'student_id') {
            $student = \App\Models\Student::where('student_id', $credentials['student_id'])->first();
            if ($student) {
                $user = $student->user;
                if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->intended('dashboard');
                }
            }
        } else {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
        }

        return back()->withErrors([
            $loginField => 'The provided credentials do not match our records.',
        ])->onlyInput($loginField);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
