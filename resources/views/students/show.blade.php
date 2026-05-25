@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
<div class="max-w-4xl">
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('students.index') }}" class="flex items-center hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Back to Records
        </a>
        <span>›</span>
        <span class="font-medium text-gray-800">Student Profile</span>
    </nav>

    <div class="mb-10 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $student->user->name }}</h2>
            <p class="text-gray-500">Institutional ID: <span class="font-mono font-bold text-blue-600">{{ $student->student_id }}</span></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('enrollments.create', ['student_id' => $student->id]) }}" class="px-5 py-2.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg font-semibold hover:bg-blue-100 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Manage Enrollment
            </a>
            <a href="{{ route('students.edit', $student) }}" class="px-5 py-2.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-semibold hover:bg-amber-100 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Edit Profile
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-8">
            <section class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Academic Information</h3>
                </div>
                <div class="p-8 grid grid-cols-2 gap-8">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Course / Program</p>
                        <p class="text-gray-900 font-semibold">{{ $student->course }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Year & Section</p>
                        <p class="text-gray-900 font-semibold">{{ $student->year_level }} - {{ $student->section }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Enrollment Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $student->status === 'Enrolled' || $student->status === 'Regular' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $student->status }}
                        </span>
                    </div>
                </div>
            </section>
        </div>

        <div class="space-y-8">
            <section class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-200">
                <p class="text-xs uppercase tracking-widest text-blue-100 mb-2">Overall GPA</p>
                <h4 class="text-4xl font-bold">{{ number_format($student->grades->avg('average') ?? 0, 2) }}</h4>
                <div class="mt-6 pt-6 border-t border-blue-500/50">
                    <p class="text-xs text-blue-100">Subjects Enrolled: <span class="font-bold text-white">{{ $student->subjects->count() }}</span></p>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
