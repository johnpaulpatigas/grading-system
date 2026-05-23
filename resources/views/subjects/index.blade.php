@extends('layouts.app')

@section('title', 'Academic Subjects')

@section('content')
<div class="flex justify-between items-start mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">Academic Subjects</h2>
        <p class="text-slate-500 mt-1 max-w-2xl">Manage the curriculum database and configure credit units for the current academic year.</p>
    </div>
    <a href="{{ route('subjects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 font-medium transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Add New Subject
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-xl shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Subject Code</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Units</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($subjects as $subject)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-blue-600">{{ $subject->subject_code }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-slate-800">{{ $subject->description }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ number_format($subject->units, 1) }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('subjects.edit', $subject) }}" class="text-gray-400 hover:text-amber-600" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            </a>
                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
