@extends('layouts.app')

@section('title', 'Faculty Management')

@section('content')
<!-- BEGIN: Content Header -->
<div class="flex justify-between items-start mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Faculty Management</h2>
        <p class="text-gray-500 mt-1">Manage teaching staff, assignments, and departmental details.</p>
    </div>
    <a href="{{ route('faculty.create') }}" class="bg-[#0D47A1] text-white px-5 py-2.5 rounded-lg flex items-center gap-2 hover:bg-blue-800 transition-shadow shadow-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Add Teacher
    </a>
</div>
<!-- END: Content Header -->

<!-- BEGIN: Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Metric Card 1 -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 flex flex-col justify-between relative overflow-hidden">
        <div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Faculty</span>
            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $faculties->count() }}</div>
        </div>
        <div class="mt-4 flex items-center text-emerald-500 text-sm font-medium">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewbox="0 0 20 20"><path clip-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" fill-rule="evenodd"></path></svg>
            Active
        </div>
        <div class="absolute top-6 right-6 p-2 bg-blue-50 text-blue-600 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
    </div>
    <!-- Metric Card 2 -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 flex flex-col justify-between relative overflow-hidden">
        <div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Active Teachers</span>
            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $faculties->count() }}</div>
        </div>
        <div class="mt-4 text-gray-500 text-sm font-medium">
            100% of total faculty
        </div>
        <div class="absolute top-6 right-6 p-2 bg-emerald-50 text-emerald-600 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
    </div>
    <!-- Metric Card 3 -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 flex flex-col justify-between relative overflow-hidden">
        <div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pending Reviews</span>
            <div class="text-3xl font-bold text-gray-900 mt-2">0</div>
        </div>
        <div class="mt-4 text-gray-500 text-sm font-medium">
            No attention required
        </div>
        <div class="absolute top-6 right-6 p-2 bg-amber-50 text-amber-600 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
    </div>
    <!-- Metric Card 4 -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 flex flex-col justify-between relative overflow-hidden">
        <div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Depts Covered</span>
            <div class="text-3xl font-bold text-gray-900 mt-2">{{ $faculties->unique('department')->count() }}</div>
        </div>
        <div class="mt-4 text-gray-500 text-sm font-medium">
            Across active faculties
        </div>
        <div class="absolute top-6 right-6 p-2 bg-gray-50 text-gray-600 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </div>
    </div>
</div>
<!-- END: Stats Grid -->

<!-- BEGIN: Table Section Container -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <!-- Filter Bar -->
    <form method="GET" action="{{ route('faculty.index') }}" class="p-4 border-b border-gray-200 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button type="button" class="flex items-center gap-2 text-gray-700 font-medium text-sm px-3 py-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Filters:
            </button>
            <div class="relative">
                <select name="department" onchange="this.form.submit()" class="appearance-none bg-none bg-gray-50 border border-gray-300 rounded-lg text-sm px-4 py-2 pr-10 focus:ring-blue-500 focus:border-blue-500">
                    <option value="All Department">All Department</option>
                    @php $allDepts = \App\Models\Faculty::select('department')->distinct()->pluck('department'); @endphp
                    @foreach($allDepts as $dept)
                        <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <a href="{{ route('faculty.index') }}" class="text-blue-600 font-semibold text-sm hover:underline">Clear Filters</a>
    </form>

    <!-- Staff Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Staff Name</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee ID</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Primary Dept</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($faculties as $faculty)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $faculty->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $faculty->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $faculty->employee_id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $faculty->department }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Active</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('faculty.edit', $faculty) }}" class="text-gray-400 hover:text-amber-600" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            </a>
                            <form action="{{ route('faculty.destroy', $faculty) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-gray-400 hover:text-red-600" title="Delete" onclick="showConfirmModal('Are you sure you want to delete this faculty record?', 'Delete Faculty', this.closest('form'))">
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
<!-- END: Table Section Container -->
@endsection
