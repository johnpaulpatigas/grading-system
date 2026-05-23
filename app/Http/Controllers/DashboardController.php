<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return view('admin.dashboard');
        } elseif ($user->isFaculty()) {
            return view('faculty.dashboard');
        } else {
            return view('student.dashboard');
        }
    }

    public function reports()
    {
        return view('reports.index');
    }
}
