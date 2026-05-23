@extends('layouts.app')

@section('title', 'Student Records')

@section('content')
<!-- BEGIN: Content Header -->
<div class="mb-6">
    <div class="flex items-start justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Student Records</h2>
            <p class="text-gray-500 mt-1">Manage and monitor academic profiles of all enrolled students.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Export List
            </button>
            <a href="{{ route('students.create') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-lg font-medium hover:bg-blue-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Add Student
            </a>
        </div>
    </div>
    <!-- BEGIN: Filter Bar -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 text-gray-600 font-medium mr-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Filters:
            </div>
            <select class="rounded-lg border-gray-300 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500 min-w-[160px]">
                <option>All Courses</option>
                <option>BS Computer Science</option>
                <option>BS Information Tech</option>
                <option>BS Mech Eng</option>
            </select>
            <select class="rounded-lg border-gray-300 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500 min-w-[140px]">
                <option>Year Level</option>
                <option>1st Year</option>
                <option>2nd Year</option>
                <option>3rd Year</option>
                <option>4th Year</option>
            </select>
            <select class="rounded-lg border-gray-300 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500 min-w-[140px]">
                <option>All Sections</option>
                <option>Section A-1</option>
                <option>Section B-4</option>
                <option>Section C-1</option>
            </select>
        </div>
        <button class="text-blue-600 font-semibold hover:underline text-sm">Clear Filters</button>
    </div>
    <!-- END: Filter Bar -->
</div>
<!-- END: Content Header -->

<!-- BEGIN: Students Table Container -->
<div class="h-full bg-white border border-gray-200 rounded-xl flex flex-col shadow-sm">
    <div class="flex-1 overflow-auto custom-scrollbar">
        <table class="w-full text-left border-collapse" id="student-records-table">
            <thead class="sticky top-0 bg-gray-50 z-10 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center gap-1 cursor-pointer">
                            STUDENT ID
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">FULL NAME</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">COURSE</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">YEAR LEVEL</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">SECTION</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">STATUS</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($students as $student)
                <tr class="hover:bg-blue-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <span class="text-blue-600 font-medium text-sm">{{ $student->student_id }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900">{{ $student->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $student->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $student->course }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $student->year_level }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $student->section }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $student->status === 'Enrolled' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $student->status === 'Enrolled' ? 'bg-green-500' : 'bg-amber-500' }} mr-1.5"></span>
                            {{ $student->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('students.show', $student) }}" class="hover:text-blue-600" title="View"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a>
                            <a href="{{ route('students.edit', $student) }}" class="hover:text-amber-600" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hover:text-red-600" title="Delete" onclick="return confirm('Are you sure?')"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- BEGIN: Table Footer / Pagination -->
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between text-sm text-gray-600">
        <div>Showing {{ $students->count() }} entries</div>
        <div class="flex gap-2">
            <!-- Simplified pagination for demo -->
            <button class="px-3 py-1 border border-gray-300 rounded bg-white hover:bg-gray-50 disabled:opacity-50" disabled="">Previous</button>
            <button class="px-3 py-1 border border-blue-500 rounded bg-blue-50 text-blue-700 font-medium">1</button>
            <button class="px-3 py-1 border border-gray-300 rounded bg-white hover:bg-gray-50" disabled>Next</button>
        </div>
    </div>
    <!-- END: Table Footer / Pagination -->
</div>
<!-- END: Students Table Container -->
@endsection
