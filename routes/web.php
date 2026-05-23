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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('students', StudentController::class);
    Route::resource('faculty', FacultyController::class);
    Route::resource('subjects', SubjectController::class);
    
    Route::get('/grading', [GradeController::class, 'index'])->name('grading.index');
    Route::get('/grading/encode/{student}', [GradeController::class, 'encode'])->name('grading.encode');
    Route::post('/grading/store', [GradeController::class, 'store'])->name('grading.store');
    
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports.index');
});
