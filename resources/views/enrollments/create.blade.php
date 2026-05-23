@extends('layouts.app')

@section('title', 'New Enrollment')

@section('content')
<div class="max-w-4xl">
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Go Back
        </a>
        <span>›</span>
        <span class="font-medium text-gray-800">Enrollment</span>
    </nav>

    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-1">New Enrollment</h2>
        <p class="text-gray-500">Register students into their respective academic subjects.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-8">
            <form action="{{ route('enrollments.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Student Selection -->
                <div class="space-y-4">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest" for="student_id">Select Student <span class="text-red-500">*</span></label>
                    <select class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-50/50 appearance-none bg-none bg-no-repeat bg-[right_1rem_center]" id="student_id" name="student_id" required>
                        <option value="">Choose a student...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $selectedStudentId == $student->id ? 'selected' : '' }}>
                                {{ $student->student_id }} - {{ $student->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Subject Selection (Multi-select) -->
                <div class="space-y-4">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Select Subjects <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($subjects as $subject)
                            @php
                                $isEnrolled = $selectedStudentId ? $students->find($selectedStudentId)?->subjects->contains($subject->id) : false;
                            @endphp
                            <label class="flex items-center p-4 border border-gray-100 rounded-xl hover:bg-blue-50/50 transition-colors cursor-pointer group">
                                <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ $isEnrolled ? 'checked' : '' }}>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900 group-hover:text-blue-700">{{ $subject->subject_code }}</p>
                                    <p class="text-xs text-gray-500">{{ $subject->description }} ({{ number_format($subject->units, 1) }} Units)</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('subject_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-8 flex justify-end">
                    <button class="bg-[#0047cc] hover:bg-blue-700 text-white font-semibold py-3 px-10 rounded-lg flex items-center space-x-2 transition-all shadow-md active:scale-95" type="submit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        <span>Confirm Enrollment</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Refresh page when student changes to show current enrollments
    document.getElementById('student_id').addEventListener('change', function() {
        if (this.value) {
            window.location.href = "{{ route('enrollments.create') }}?student_id=" + this.value;
        }
    });
</script>
@endsection
