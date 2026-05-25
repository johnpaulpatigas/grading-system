<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@cpc.edu',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        $facultyUser = User::create([
            'name' => 'Faculty User',
            'email' => 'faculty@cpc.edu',
            'password' => Hash::make('password'),
            'role' => 'faculty',
        ]);

        \App\Models\Faculty::create([
            'user_id' => $facultyUser->id,
            'employee_id' => 'FAC-2026-001',
            'department' => 'College of Computer Studies',
        ]);
        
        $studentUser = User::create([
            'name' => 'Student User',
            'email' => 'student@cpc.edu',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        \App\Models\Student::create([
            'user_id' => $studentUser->id,
            'student_id' => '20230753',
            'course' => 'BS Information Technology',
            'year_level' => '3rd Year',
            'section' => 'A-1',
        ]);
    }
}
