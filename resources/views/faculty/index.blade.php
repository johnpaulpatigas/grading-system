@extends('layouts.app')

@section('title', 'Faculty Management')

@section('content')
<div class="flex justify-between items-start mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Faculty Management</h2>
        <p class="text-gray-500 mt-1">Manage teaching staff, assignments, and departmental details.</p>
    </div>
    <a href="{{ route('faculty.create') }}" class="bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 hover:bg-blue-800 transition-shadow shadow-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Add Teacher
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Staff Name</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee ID</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Primary Dept</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($faculties as $faculty)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $faculty->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $faculty->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $faculty->employee_id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $faculty->department }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('faculty.edit', $faculty) }}" class="text-gray-400 hover:text-amber-600" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            </a>
                            <form action="{{ route('faculty.destroy', $faculty) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
