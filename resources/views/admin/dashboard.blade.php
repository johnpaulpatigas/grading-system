@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-900">Registrar Dashboard</h2>
    <p class="text-gray-500 mt-1">Real-time overview of academic records and institutional performance.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Students</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-bold text-gray-900">11,240</span>
                <span class="text-xs font-semibold text-green-500">2.4%</span>
            </div>
        </div>
        <button class="mt-6 w-full py-2.5 bg-[#0052cc] text-white rounded-lg flex items-center justify-center gap-2 text-sm font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Add Student
        </button>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Subjects</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-bold text-gray-900">48</span>
                <span class="text-xs font-semibold text-gray-400">Active</span>
            </div>
        </div>
        <button class="mt-6 w-full py-2.5 bg-[#0052cc] text-white rounded-lg flex items-center justify-center gap-2 text-sm font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Add Subject
        </button>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Encoded Grades</span>
            <div class="flex items-center gap-4 mt-1">
                <span class="text-3xl font-bold text-gray-900">85%</span>
                <div class="flex-1 bg-gray-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-500 h-full w-[85%] rounded-full"></div>
                </div>
            </div>
        </div>
        <button class="mt-6 w-full py-2.5 bg-[#0052cc] text-white rounded-lg flex items-center justify-center gap-2 text-sm font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Add Teacher
        </button>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Passing Rate</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-bold text-gray-900">92%</span>
                <span class="text-xs font-semibold text-green-500">Strong</span>
            </div>
        </div>
        <div class="mt-6 h-10"></div>
    </div>
</div>
@endsection
