@extends('layouts.app')

@section('title', 'Select Student for Report')

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-bold text-gray-900 mb-1">Grade Reports</h2>
    <p class="text-gray-500">Select a student to generate their official report of grades.</p>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="p-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="py-4 px-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Student ID</th>
                        <th class="py-4 px-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Name</th>
                        <th class="py-4 px-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Course & Year</th>
                        <th class="py-4 px-6 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($students as $student)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6 font-mono text-sm text-blue-600">{{ $student->student_id }}</td>
                        <td class="py-4 px-6 font-bold text-gray-900">{{ $student->user->name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $student->course }} - Year {{ $student->year_level }}</td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('reports.index', ['student_id' => $student->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-600 hover:text-white transition-all">
                                Generate Report
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
