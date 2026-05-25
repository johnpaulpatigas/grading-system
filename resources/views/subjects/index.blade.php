@extends('layouts.app')

@section('title', 'Academic Subjects')

@section('content')
<!-- Page Title Section -->
<div class="flex justify-between items-start mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">Academic Subjects</h2>
        <p class="text-slate-500 mt-1 max-w-2xl">Manage the curriculum database, assign instructors, and configure credit units for the current academic year.</p>
    </div>
    <a href="{{ route('subjects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 font-medium transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Add New Subject
    </a>
</div>

<!-- BEGIN: Stats Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Subjects Card -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Updated</span>
        </div>
        <p class="text-slate-500 text-sm font-medium">Total Subjects</p>
        <h3 class="text-3xl font-bold mt-1">{{ $subjects->count() }}</h3>
    </div>
    <!-- Assigned Faculty Card -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
        </div>
        <p class="text-slate-500 text-sm font-medium">Assigned Faculty</p>
        <h3 class="text-3xl font-bold mt-1">-</h3>
    </div>
    <!-- Pending Reviews Card -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
        </div>
        <p class="text-slate-500 text-sm font-medium">Pending Reviews</p>
        <h3 class="text-3xl font-bold mt-1">0</h3>
    </div>
    <!-- Avg Units Card -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
        </div>
        <p class="text-slate-500 text-sm font-medium">Avg. Units/Subject</p>
        <h3 class="text-3xl font-bold mt-1">{{ number_format($subjects->avg('units'), 1) }}</h3>
    </div>
</div>
<!-- END: Stats Summary Cards -->

<!-- BEGIN: Table Section -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <!-- Table Filters -->
    <form method="GET" action="{{ route('subjects.index') }}" class="p-4 border-b border-slate-100 flex flex-wrap items-center gap-4">
        <div class="relative flex-1 min-w-[300px]">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </span>
            <input name="search" value="{{ request('search') }}" class="w-full border border-slate-200 rounded-lg py-2 pl-10 pr-4 focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Search subjects..." type="text"/>
        </div>
        @if(request()->has('search'))
            <a href="{{ route('subjects.index') }}" class="text-blue-600 text-sm font-semibold hover:underline">Clear Search</a>
        @endif
    </form>
    <!-- Subjects Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject Code</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Units</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($subjects as $subject)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-4 text-sm font-medium text-blue-600">{{ $subject->subject_code }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-slate-800">{{ $subject->description }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ number_format($subject->units, 1) }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">ACTIVE</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('subjects.edit', $subject) }}" class="text-slate-400 hover:text-amber-600" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            </a>
                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-slate-400 hover:text-red-600" title="Delete" onclick="showConfirmModal('Are you sure you want to delete this subject record?', 'Delete Subject', this.closest('form'))">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- END: Table Section -->
@endsection
