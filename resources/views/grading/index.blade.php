@extends('layouts.app')

@section('title', 'Grade Encoding')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-4">
        <h2 class="text-2xl font-bold text-slate-800 border-r border-slate-300 pr-4">Grade Encoding</h2>
        <form action="{{ route('grading.index') }}" method="GET" id="subject-filter-form">
            <select name="subject_id" onchange="this.form.submit()" class="appearance-none bg-blue-50 border border-blue-100 text-blue-700 font-semibold py-2.5 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                    {{ $subject->subject_code }}: {{ $subject->description }}
                </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white">
        <div class="flex items-center space-x-3">
            <span class="font-bold text-slate-700">Student List</span>
            <span class="bg-slate-100 text-slate-500 text-xs px-2.5 py-1 rounded-full font-medium">{{ count($students) }} Records Found</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-[10px] uppercase tracking-wider text-slate-500 font-bold">
                <tr>
                    <th class="px-6 py-4">Student ID</th>
                    <th class="px-6 py-4">Full Name</th>
                    <th class="px-6 py-4 text-center">Grade</th>
                    <th class="px-6 py-4 text-center">Remarks</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                @foreach($students as $student)
                @php $grade = $student->grades->first(); @endphp
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-5 font-medium">{{ $student->student_id }}</td>
                    <td class="px-6 py-5 font-bold text-slate-800">{{ $student->user->name }}</td>
                    <td class="px-6 py-5 text-center">
                        @if($grade)
                        <span class="font-bold {{ $grade->grade >= 75 ? 'text-blue-600' : 'text-red-600' }}">{{ $grade->grade }}</span>
                        @else
                        <span class="text-slate-400">--</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($grade)
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $grade->grade >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            {{ $grade->grade >= 75 ? 'Pass' : 'Fail' }}
                        </span>
                        @else
                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-right">
                        <a href="{{ route('grading.encode', ['student' => $student->id, 'subject_id' => $selectedSubjectId]) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                            Encode Grade
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
