<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    // Shared Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports.index');

    // Admin Only: Full Access to Management
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('faculty', FacultyController::class);
        Route::resource('subjects', SubjectController::class);
    });

    // Admin & Faculty: Grading Access
    Route::middleware(['role:admin,faculty'])->group(function () {
        Route::get('/grading', [GradeController::class, 'index'])->name('grading.index');
        Route::get('/grading/encode/{student}', [GradeController::class, 'encode'])->name('grading.encode');
        Route::post('/grading/store', [GradeController::class, 'store'])->name('grading.store');
    });
});
