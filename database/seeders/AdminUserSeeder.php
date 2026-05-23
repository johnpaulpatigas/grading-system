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
        
        User::create([
            'name' => 'Faculty User',
            'email' => 'faculty@cpc.edu',
            'password' => Hash::make('password'),
            'role' => 'faculty',
        ]);
        
        User::create([
            'name' => 'Student User',
            'email' => 'student@cpc.edu',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}
