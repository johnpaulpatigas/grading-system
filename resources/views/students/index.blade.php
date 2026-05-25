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
            <button onclick="exportToPDF()" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
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
    <form method="GET" action="{{ route('students.index') }}" class="bg-white p-4 rounded-xl border border-gray-200 flex flex-col md:flex-row items-center justify-between shadow-sm gap-4">
        <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
            <div class="flex items-center gap-2 text-gray-600 font-medium mr-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Filters:
            </div>
            <select name="course" class="rounded-lg border-gray-300 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500 min-w-[160px] appearance-none bg-none" onchange="this.form.submit()">
                <option value="All Courses">All Courses</option>
                @foreach(\App\Models\Student::COURSES as $course)
                    <option value="{{ $course }}" {{ request('course') === $course ? 'selected' : '' }}>{{ $course }}</option>
                @endforeach
            </select>
            <select name="year_level" id="year_level" class="rounded-lg border-gray-300 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500 min-w-[140px] appearance-none bg-none" onchange="updateSections(); this.form.submit()">
                <option value="Year Level">Year Level</option>
                @foreach(\App\Models\Student::YEAR_LEVELS as $label => $num)
                    <option value="{{ $label }}" {{ request('year_level') === $label ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <select name="section" id="section" class="rounded-lg border-gray-300 text-gray-700 text-sm focus:ring-blue-500 focus:border-blue-500 min-w-[140px] appearance-none bg-none" onchange="this.form.submit()">
                <option value="All Sections">All Sections</option>
            </select>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID or Name..." class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
            <a href="{{ route('students.index') }}" class="text-blue-600 font-semibold hover:underline text-sm whitespace-nowrap">Clear Filters</a>
        </div>
    </form>
    <!-- END: Filter Bar -->
</div>
<!-- END: Content Header -->

<!-- BEGIN: Students Table Container -->
<div id="print-container" class="h-full bg-white border border-gray-200 rounded-xl flex flex-col shadow-sm">
    <div class="flex-1 overflow-auto custom-scrollbar">
        <table class="w-full text-left border-collapse" id="student-records-table">
            <thead class="sticky top-0 bg-gray-50 z-10 border-b border-gray-200">
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
                        <div class="flex items-center justify-end gap-3 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('students.show', $student) }}" class="hover:text-blue-600" title="View"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a>
                            <a href="{{ route('students.edit', $student) }}" class="hover:text-amber-600" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg></a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="hover:text-red-600" title="Delete" onclick="showConfirmModal('Are you sure you want to delete this student record?', 'Delete Student', this.closest('form'))">
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
<!-- END: Students Table Container -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function exportToPDF() {
        const element = document.getElementById('print-container');
        const opt = {
            margin:       10,
            filename:     'Student_Records_List.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

<script>
    const yearMapping = @json(\App\Models\Student::YEAR_LEVELS);
    const sections = @json(\App\Models\Student::SECTIONS);
    const currentSection = "{{ request('section') }}";

    function updateSections() {
        const yearLevelSelect = document.getElementById('year_level');
        const sectionSelect = document.getElementById('section');
        const selectedYear = yearLevelSelect.value;
        sectionSelect.innerHTML = '<option value="All Sections">All Sections</option>';
        if (selectedYear && yearMapping[selectedYear]) {
            const num = yearMapping[selectedYear];
            sections.forEach(s => {
                const value = num + s;
                const option = document.createElement('option');
                option.value = value;
                option.textContent = 'Section ' + value;
                if (value === currentSection) option.selected = true;
                sectionSelect.appendChild(option);
            });
        }
    }
    document.addEventListener('DOMContentLoaded', updateSections);
</script>
@endsection

@push('styles')
<style type="text/css" media="print">
    /* Hide the actions column when printing/exporting */
    #student-records-table th:last-child, #student-records-table td:last-child {
        display: none !important;
    }
</style>
@endpush
