@extends('layouts.app')

@section('title', 'Report Generation')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">Report Generation</h2>
        <p class="text-gray-500 mt-1">Review and print official CPC credentials.</p>
    </div>
    <div class="flex space-x-3">
        <button class="inline-flex items-center px-5 py-2.5 border border-gray-300 rounded text-sm font-medium text-slate-700 bg-white hover:bg-gray-50 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Export PDF
        </button>
        <button class="inline-flex items-center px-5 py-2.5 bg-blue-700 border border-transparent rounded text-sm font-medium text-white hover:bg-blue-800 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Print Document
        </button>
    </div>
</div>

<!-- BEGIN: Report Preview Container -->
<div class="bg-white mx-auto p-16 border border-gray-200 shadow-lg" style="max-width: 850px; min-height: 1056px;">
    <!-- BEGIN: Document Header -->
    <div class="flex items-center justify-between pb-8 border-b-2 border-slate-800">
        <div class="flex items-center space-x-6">
            <img alt="CPC Seal" class="w-24 h-24" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOHv9PTkVMszjQ1mMud-gtqRsixD-d-lrECOo20DuPt4gfiiSn-YLV6H82uCyVVmsxA_I0DoOf0CHgS-gPopQIelNy7_OigUbJbfxXMWSAJxUoEZF6lP1i_7OCxpb6QTvjTBUJysyjNs_I9fBztODaO3fpwtY-yYMPkOaP7Qe620JbTZifysIvEsk15yOAHgLeoWCM8KRbCJJgDxNhKY5tD5u2kq6bdyCkUnttb87mWcKdVQwfM37Hg6AJICKlVcGMXJJkEfckZ48"/>
            <div>
                <h3 class="text-4xl font-extrabold tracking-tight text-slate-800 leading-none">CORDOVA PUBLIC COLLEGE</h3>
                <p class="text-xs font-bold tracking-[0.2em] text-slate-600 mt-2">OFFICE OF THE COLLEGE REGISTRAR</p>
                <p class="text-xs text-slate-500 mt-1">Barangay Gabi, Cordova, Cebu, Philippines</p>
            </div>
        </div>
        <div class="text-right">
            <div class="bg-slate-800 text-white px-3 py-1 text-[10px] font-bold inline-block mb-3 uppercase tracking-wider">Official Document</div>
            <h4 class="text-3xl font-bold text-slate-800 leading-tight">Official Report of Grades</h4>
            <p class="text-xs font-mono text-slate-500 mt-1">Ref No: 2026-RC-008429</p>
        </div>
    </div>
    <!-- END: Document Header -->

    <!-- BEGIN: Student Information Section -->
    <div class="grid grid-cols-2 gap-8 py-10 bg-gray-50/50 px-8 border border-gray-100 mt-8 rounded-sm">
        <div class="space-y-6">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Student Name</p>
                <p class="text-lg font-bold text-slate-800 uppercase">{{ Auth::user()->name }}</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Student ID Number</p>
                <p class="text-xl font-bold text-slate-700 tracking-wider">2021-00045-MN-0</p>
            </div>
        </div>
        <div class="space-y-6">
            <div class="grid grid-cols-2">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Semester</p>
                    <p class="font-bold text-slate-800">First Semester</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Academic Year</p>
                    <p class="font-bold text-slate-800">2023 - 2024</p>
                </div>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Degree Program</p>
                <p class="font-bold text-slate-800 leading-tight">Bachelor of Science in Information Technology (BSIT)</p>
            </div>
        </div>
    </div>
    <!-- END: Student Information Section -->

    <!-- BEGIN: Grades Table -->
    <div class="mt-12 overflow-hidden border border-slate-800 rounded-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800 text-white">
                    <th class="py-3 px-6 text-[11px] font-bold uppercase tracking-wider">Subject Code</th>
                    <th class="py-3 px-6 text-[11px] font-bold uppercase tracking-wider">Descriptive Title</th>
                    <th class="py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-center">Units</th>
                    <th class="py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-center">Final Grade</th>
                    <th class="py-3 px-6 text-[11px] font-bold uppercase tracking-wider text-center">Remarks</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-5 px-6 font-bold text-blue-700 text-sm">ITEC 30013</td>
                    <td class="py-5 px-6 text-sm text-slate-700">Advanced Database Systems</td>
                    <td class="py-5 px-6 text-sm text-center text-slate-600">3.0</td>
                    <td class="py-5 px-6 font-bold text-lg text-center text-slate-800">1.25</td>
                    <td class="py-5 px-6 text-center">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase tracking-wider border border-green-200">Pass</span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-5 px-6 font-bold text-blue-700 text-sm">ITEC 30023</td>
                    <td class="py-5 px-6 text-sm text-slate-700">Software Engineering 2</td>
                    <td class="py-5 px-6 text-sm text-center text-slate-600">3.0</td>
                    <td class="py-5 px-6 font-bold text-lg text-center text-slate-800">1.50</td>
                    <td class="py-5 px-6 text-center">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase tracking-wider border border-green-200">Pass</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- END: Grades Table -->

    <div class="mt-20 pt-10 border-t border-gray-100 flex justify-between text-[10px] text-slate-400 uppercase tracking-[0.2em]">
        <p>This is a computer-generated document.</p>
        <p>Page 1 of 1</p>
    </div>
</div>
<!-- END: Report Preview Container -->
@endsection
