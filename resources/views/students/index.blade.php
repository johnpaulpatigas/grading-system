@extends('layouts.app')

@section('title', 'Student Records')

@section('content')
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

<div class="bg-white border border-gray-200 rounded-xl flex flex-col shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">STUDENT ID</th>
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
                            {{ $student->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('students.edit', $student) }}" class="text-gray-400 hover:text-amber-600" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            </a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600" title="Delete">
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
@endsection
