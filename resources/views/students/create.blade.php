@extends('layouts.app')

@section('title', 'Add Student Record')

@section('content')
<!-- BEGIN: PageContent -->
<div class="max-w-4xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a class="flex items-center hover:text-gray-800 transition-colors" href="{{ route('students.index') }}">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Go Back
        </a>
        <span>›</span>
        <span class="font-medium text-gray-800">Add Student</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-1">Add Student Record</h2>
        <p class="text-gray-500">Create a new student entry for the grading system.</p>
    </div>

    <!-- BEGIN: RecordFormCard -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-8">
            <!-- Section Heading -->
            <div class="flex items-center space-x-4 mb-8">
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Personal Student Information</h3>
                    <p class="text-sm text-gray-500">Enter official legal details and contact information.</p>
                </div>
            </div>

            <!-- Form Fields Grid -->
            <form action="{{ route('students.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Name (Combining First/Last for simplicity) -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="name">Full Name <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="name" name="name" placeholder="e.g. Jane Doe" type="text" value="{{ old('name') }}" required/>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="email">Email Address <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="email" name="email" placeholder="jane.doe@cpc.edu" type="email" value="{{ old('email') }}" required/>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Student ID -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="student_id">Student ID <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="student_id" name="student_id" placeholder="2023-0001" type="text" value="{{ old('student_id') }}" required/>
                        @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Course/Department -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="course">Course <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-gray-600 appearance-none bg-none bg-no-repeat bg-[right_1rem_center]" id="course" name="course" required>
                            <option value="">Select Course</option>
                            @foreach(\App\Models\Student::COURSES as $course)
                                <option value="{{ $course }}" {{ old('course') === $course ? 'selected' : '' }}>{{ $course }}</option>
                            @endforeach
                        </select>
                        @error('course') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Year Level -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="year_level">Year Level <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-gray-600 appearance-none bg-none bg-no-repeat bg-[right_1rem_center]" id="year_level" name="year_level" required onchange="updateSections()">
                            <option value="">Select Year</option>
                            @foreach(\App\Models\Student::YEAR_LEVELS as $label => $num)
                                <option value="{{ $label }}" {{ old('year_level') === $label ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('year_level') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Section -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="section">Section <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-gray-600 appearance-none bg-none bg-no-repeat bg-[right_1rem_center]" id="section" name="section" required>
                            <option value="">Select Section</option>
                        </select>
                        @error('section') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Form Action Footer -->
                <div class="pt-10 flex justify-end">
                    <button class="bg-[#0047cc] hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg flex items-center space-x-2 transition-all" type="submit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        <span>Save Record</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- END: RecordFormCard -->
</div>

<script>
    const yearMapping = @json(\App\Models\Student::YEAR_LEVELS);
    const sections = @json(\App\Models\Student::SECTIONS);

    function updateSections() {
        const yearLevelSelect = document.getElementById('year_level');
        const sectionSelect = document.getElementById('section');
        const selectedYear = yearLevelSelect.value;
        const oldSection = "{{ old('section') }}";

        sectionSelect.innerHTML = '<option value="">Select Section</option>';

        if (selectedYear && yearMapping[selectedYear]) {
            const num = yearMapping[selectedYear];
            sections.forEach(s => {
                const value = num + s;
                const option = document.createElement('option');
                option.value = value;
                option.textContent = 'Section ' + value;
                if (value === oldSection) {
                    option.selected = true;
                }
                sectionSelect.appendChild(option);
            });
        }
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', updateSections);
</script>
@endsection
