@extends('layouts.app')

@section('title', 'Grade Encoding')

@section('content')
@if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<!-- BEGIN: Dashboard Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Class Performance -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex justify-between items-start mb-2">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Class Performance</h3>
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <div class="flex items-baseline space-x-2">
            @php
                $averageGrade = $students->flatMap->grades->avg('average');
            @endphp
            <span class="text-3xl font-bold text-blue-600">{{ $averageGrade ? number_format($averageGrade, 1) . '%' : 'N/A' }}</span>
        </div>
        <p class="text-xs text-emerald-500 mt-2 font-medium">Live Average</p>
    </div>
    <!-- Grading Completion -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex justify-between items-start mb-2">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Grading Completion</h3>
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <div class="text-3xl font-bold text-slate-800">
            @php
                $totalStudents = $students->count();
                $gradedStudents = $students->filter(fn($s) => $s->grades->isNotEmpty())->count();
                $completion = $totalStudents > 0 ? ($gradedStudents / $totalStudents) * 100 : 0;
            @endphp
            {{ number_format($completion, 0) }}%
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2 mt-4 overflow-hidden">
            <div class="bg-blue-600 h-full" style="width: {{ $completion }}%"></div>
        </div>
        <p class="text-xs text-slate-400 mt-2">{{ $gradedStudents }}/{{ $totalStudents }} students graded</p>
    </div>
    <!-- Total Students -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
        <div class="flex justify-between items-start mb-2">
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Students</h3>
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <div class="text-3xl font-bold text-slate-800">{{ $totalStudents }}</div>
        <p class="text-xs text-slate-400 mt-2">Across selected subject</p>
    </div>
    <!-- Generate Report Button -->
    <a href="{{ route('reports.index') }}" class="bg-white p-6 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400 hover:border-blue-400 hover:text-blue-500 transition-all group">
        <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        <span class="font-bold text-sm text-slate-700">Generate Report</span>
    </a>
</div>
<!-- END: Dashboard Stats -->

<!-- BEGIN: Grade Encoding Header -->
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-4">
        <h2 class="text-2xl font-bold text-slate-800 border-r border-slate-300 pr-4">Grade Encoding</h2>
        <form action="{{ route('grading.index') }}" method="GET" class="relative">
            <select name="subject_id" onchange="this.form.submit()" class="appearance-none bg-none bg-blue-50 border border-blue-100 text-blue-700 font-semibold py-2.5 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                        {{ $subject->subject_code }}: {{ $subject->description }}
                    </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-blue-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
        </form>
    </div>
    <div class="flex items-center space-x-3">
        <form action="{{ route('grading.submit') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
            <button type="button" onclick="showConfirmModal('Are you sure you want to finalize these grades? They cannot be edited afterwards.', 'Finalize Grades', this.closest('form'))" class="px-8 py-2.5 bg-[#0258E3] text-white font-semibold text-sm rounded-lg hover:bg-blue-700 shadow-md transition-all">Submit Grades</button>
        </form>    </div>
</div>
<!-- END: Grade Encoding Header -->

<!-- BEGIN: Student Table Container -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <!-- Table Header Toolbar -->
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
        <div class="flex items-center space-x-3">
            <span class="font-bold text-slate-700">Student List</span>
            <span class="bg-slate-100 text-slate-500 text-xs px-2.5 py-1 rounded-full font-medium">{{ $students->count() }} Records Found</span>
        </div>
    </div>
    <!-- Main Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-[10px] uppercase tracking-wider text-slate-500 font-bold">
                <tr>
                    <th class="px-6 py-4">Student ID</th>
                    <th class="px-6 py-4">Full Name</th>
                    <th class="px-6 py-4 text-center">Prelim (30%)</th>
                    <th class="px-6 py-4 text-center">Midterm (30%)</th>
                    <th class="px-6 py-4 text-center">Final (40%)</th>
                    <th class="px-6 py-4 text-center">Average</th>
                    <th class="px-6 py-4 text-center">Remarks</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-600 divide-y divide-gray-100">
                @foreach($students as $student)
                @php
                    $grade = $student->grades->first();
                @endphp
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-5 font-medium">{{ $student->student_id }}</td>
                    <td class="px-6 py-5 font-bold text-slate-800">{{ $student->user->name }}</td>
                    <td class="px-6 py-5 text-center"><span class="{{ $grade && $grade->prelim ? 'text-slate-700' : 'text-slate-400' }}">{{ $grade?->prelim ?? '--' }}</span></td>
                    <td class="px-6 py-5 text-center"><span class="{{ $grade && $grade->midterm ? 'text-slate-700' : 'text-slate-400' }}">{{ $grade?->midterm ?? '--' }}</span></td>
                    <td class="px-6 py-5 text-center"><span class="{{ $grade && $grade->final ? 'text-slate-700' : 'text-slate-400' }}">{{ $grade?->final ?? '--' }}</span></td>
                    <td class="px-6 py-5 text-center font-bold text-blue-600">{{ $grade ? number_format($grade->average, 1) : '--' }}</td>
                    <td class="px-6 py-5 text-center">
                        @if($grade)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $grade->average >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            {{ $grade->remarks }}
                        </span>
                        @else
                        <span class="text-slate-400 text-xs">No Grade</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($grade && $grade->status === 'Final')
                            <span class="text-xs font-bold text-blue-600">FINAL</span>
                        @else
                            <span class="text-xs font-medium text-amber-500">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex justify-end space-x-3 text-slate-400">
                            @if($grade && $grade->status === 'Final' && !Auth::user()->isAdmin())
                                <span class="text-xs text-slate-400">Locked</span>
                            @else
                                <a href="{{ route('grading.encode', ['student' => $student->id, 'subject_id' => $selectedSubjectId]) }}" class="hover:text-blue-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- END: Student Table Container -->
@endsection
