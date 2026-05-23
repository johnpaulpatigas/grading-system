@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<!-- Page Header -->
<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Student Dashboard</h2>
        <p class="text-gray-500">Academic Year 2023-2024</p>
    </div>
    <div class="flex gap-2">
        <button class="px-4 py-2 border border-gray-200 rounded-lg flex items-center gap-2 hover:bg-gray-50 transition-colors font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            1st Semester
        </button>
    </div>
</div>

<!-- Bento Grid Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- GPA Card (Featured) -->
    <div class="bg-blue-600 p-6 rounded-xl text-white relative overflow-hidden group shadow-lg shadow-blue-200">
        <div class="relative z-10 flex justify-between items-start mb-6">
            <div>
                <p class="text-xs uppercase tracking-widest text-blue-100">Semestral GPA</p>
                <h3 class="text-5xl font-bold mt-1">{{ number_format($gpa ?? 0, 2) }}</h3>
            </div>
            <svg class="w-8 h-8 text-blue-300 opacity-40" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <div class="relative z-10 flex items-center gap-2 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            <span class="font-semibold">^Live</span>
            <span class="text-blue-100 text-sm">Real-time data</span>
        </div>
        <p class="relative z-10 font-semibold mt-4">Current Academic Standing</p>
    </div>
    <!-- Units Earned -->
    <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold">Units Earned</p>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <div class="flex items-baseline gap-1 mb-2">
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($unitsEarned, 1) }}</h3>
            <span class="text-gray-400">Credits</span>
        </div>
        <div class="w-full bg-gray-100 h-1.5 rounded-full mt-4 overflow-hidden">
            <div class="bg-blue-600 h-full w-[100%]"></div>
        </div>
        <p class="text-xs text-gray-400 mt-3">Current Semester Load</p>
    </div>
    <!-- Enrollment Status -->
    <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-6">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold">Status</p>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
        <div class="mb-4">
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider">{{ Auth::user()->student->status ?? 'Enrolled' }}</span>
        </div>
        <p class="text-sm text-gray-600 font-medium">Good Standing</p>
        <p class="text-xs text-gray-400 mt-1 italic">Eligibility: Fully Qualified</p>
    </div>
</div>

<!-- Grade Summary Table -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h4 class="text-xl font-bold text-gray-900">Semestral Grade Summary</h4>
            <p class="text-sm text-gray-500">Detailed academic breakdown per term for A.Y. 2023-2024</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg flex items-center gap-2 hover:bg-gray-100 transition-colors font-semibold text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Filter
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Subject Code</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Descriptive Title</th>
                    <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Prelim</th>
                    <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Midterm</th>
                    <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Final</th>
                    <th class="px-6 py-4 text-center text-[10px] font-bold text-blue-600 bg-blue-50 uppercase tracking-wider">Computed</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach(Auth::user()->student->grades ?? [] as $grade)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 font-semibold text-blue-600">{{ $grade->subject->subject_code }}</td>
                    <td class="px-6 py-5 text-gray-900 font-medium">{{ $grade->subject->description }}</td>
                    <td class="px-6 py-5 text-center"><span class="px-2 py-1 rounded-md bg-green-50 text-green-700 font-bold">--</span></td>
                    <td class="px-6 py-5 text-center"><span class="px-2 py-1 rounded-md bg-green-50 text-green-700 font-bold">--</span></td>
                    <td class="px-6 py-5 text-center"><span class="px-2 py-1 rounded-md bg-green-50 text-green-700 font-bold">--</span></td>
                    <td class="px-6 py-5 text-center bg-gray-50 font-bold text-blue-600">{{ number_format($grade->grade, 1) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-50 font-bold text-gray-900">
                    <td class="px-6 py-4 text-right text-xs uppercase tracking-wider text-gray-400" colspan="5">Semestral Average</td>
                    <td class="px-6 py-4 text-center text-xl text-blue-600 bg-blue-50 border-t-2 border-blue-600">
                        {{ number_format(Auth::user()->student->grades->avg('grade') ?? 0, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
