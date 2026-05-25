@extends('layouts.app')

@section('title', 'Edit Student Record')

@section('content')
<div class="max-w-4xl mx-auto">
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a class="flex items-center hover:text-gray-800 transition-colors" href="{{ route('students.index') }}">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Go Back
        </a>
    </nav>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Edit Student Record</h2>
        <p class="text-gray-500">Update student entry for the grading system.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-8">
            <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="name">Full Name <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" id="name" name="name" type="text" value="{{ old('name', $student->user->name) }}" required/>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="student_id">Student ID <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" id="student_id" name="student_id" maxlength="8" placeholder="20230753" type="text" value="{{ old('student_id', $student->student_id) }}" required/>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="course">Course <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" id="course" name="course" required>
                            <option value="">Select Course</option>
                            @foreach(\App\Models\Student::COURSES as $course)
                                <option value="{{ $course }}" {{ old('course', $student->course) === $course ? 'selected' : '' }}>{{ $course }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="year_level">Year Level <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" id="year_level" name="year_level" required onchange="updateSections()">
                            <option value="">Select Year</option>
                            @foreach(\App\Models\Student::YEAR_LEVELS as $label => $num)
                                <option value="{{ $label }}" {{ old('year_level', $student->year_level) == $label ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="section">Section <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" id="section" name="section" required>
                            <option value="">Select Section</option>
                        </select>
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-all" type="submit">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const yearMapping = @json(\App\Models\Student::YEAR_LEVELS);
    const sections = @json(\App\Models\Student::SECTIONS);
    const currentSection = "{{ old('section', $student->section) }}";

    function updateSections() {
        const yearLevelSelect = document.getElementById('year_level');
        const sectionSelect = document.getElementById('section');
        const selectedYear = yearLevelSelect.value;

        sectionSelect.innerHTML = '<option value="">Select Section</option>';

        if (selectedYear && yearMapping[selectedYear]) {
            const num = yearMapping[selectedYear];
            sections.forEach(s => {
                const value = num + s;
                const option = document.createElement('option');
                option.value = value;
                option.textContent = 'Section ' + value;
                if (value === currentSection) {
                    option.selected = true;
                }
                sectionSelect.appendChild(option);
            });
        }
    }
    document.addEventListener('DOMContentLoaded', updateSections);
</script>
@endsection
