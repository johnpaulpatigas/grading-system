@extends('layouts.app')

@section('title', 'Faculty Dashboard')

@section('content')
<!-- Page Header -->
<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Faculty Dashboard</h2>
        <p class="text-gray-500">Welcome back, {{ Auth::user()->name }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg flex items-center gap-2 hover:bg-gray-50 transition-colors font-semibold shadow-sm active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            View Reports
        </a>
        <a href="{{ route('grading.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors font-semibold shadow-md active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Encode Grades
        </a>
    </div>
</div>

<!-- Bento Grid Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Active Subjects -->
    <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold">Assigned Load</p>
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $totalSubjects }}</h3>
        <p class="text-sm text-gray-500">Active Subjects</p>
    </div>

    <!-- Total Units -->
    <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold">Credit Units</p>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalUnits, 1) }}</h3>
        <p class="text-sm text-gray-500">Total Teaching Load</p>
    </div>

    <!-- Total Students -->
    <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold">Students</p>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $totalStudents }}</h3>
        <p class="text-sm text-gray-500">Total Enrolled</p>
    </div>

    <!-- Grading Progress (Featured) -->
    <div class="bg-blue-600 p-6 rounded-xl text-white relative overflow-hidden group shadow-lg shadow-blue-200">
        <div class="relative z-10 flex justify-between items-start mb-6">
            <div>
                <p class="text-xs uppercase tracking-widest text-blue-100">Grading Progress</p>
                <h3 class="text-4xl font-bold mt-1">{{ number_format($gradingProgress, 0) }}%</h3>
            </div>
            <svg class="w-8 h-8 text-blue-300 opacity-40" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <div class="w-full bg-blue-900/30 h-1.5 rounded-full mt-4 overflow-hidden relative z-10">
            <div class="bg-white h-full" style="width: {{ $gradingProgress }}%"></div>
        </div>
        <p class="relative z-10 text-xs text-blue-100 mt-3">{{ $actualGrades }} of {{ $expectedGrades }} Grades Encoded</p>
    </div>
</div>

<!-- Assigned Subjects Table -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h4 class="text-xl font-bold text-gray-900">Your Classes</h4>
            <p class="text-sm text-gray-500">Subjects assigned for the current academic term</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Subject Code</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Units</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Enrolled</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($subjects as $subject)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="px-6 py-5 font-bold text-blue-600">{{ $subject->subject_code }}</td>
                    <td class="px-6 py-5 text-gray-900 font-medium">{{ $subject->description }}</td>
                    <td class="px-6 py-5 text-center text-gray-500">{{ number_format($subject->units, 1) }}</td>
                    <td class="px-6 py-5 text-center text-gray-700 font-medium">{{ $subject->students->count() }}</td>
                    <td class="px-6 py-5 text-right">
                        <a href="{{ route('grading.index', ['subject_id' => $subject->id]) }}" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors uppercase tracking-wider">
                            Manage Grades
                            <svg class="w-4 h-4 ml-1 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-gray-500 italic">You have no assigned subjects for the current term.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
