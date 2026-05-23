@extends('layouts.app')

@section('title', 'Encode Grade')

@section('content')
<!-- BEGIN: PageContent -->
<div class="max-w-4xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a class="flex items-center hover:text-gray-800 transition-colors" href="{{ route('grading.index', ['subject_id' => $subject->id]) }}">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Go Back
        </a>
        <span>›</span>
        <span class="font-medium text-gray-800">Encode Grade</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-1">Encode Student Grade</h2>
        <p class="text-gray-500">Entering academic evaluation for <span class="font-bold text-gray-900">{{ $student->user->name }}</span> in <span class="font-bold text-blue-600">{{ $subject->subject_code }}</span>.</p>
    </div>

    <!-- BEGIN: GradeFormCard -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-8">
            <!-- Section Heading -->
            <div class="flex items-center space-x-4 mb-8">
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Academic Evaluation</h3>
                    <p class="text-sm text-gray-500">Record official grades and performance remarks.</p>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('grading.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6">
                <!-- Prelim -->
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="prelim">Prelim (30%)</label>
                    <div class="relative">
                        <input class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-50/50" id="prelim" name="prelim" placeholder="0-100" type="number" step="0.01" min="0" max="100" value="{{ old('prelim', $grade?->prelim) }}"/>
                    </div>
                    @error('prelim') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Midterm -->
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="midterm">Midterm (30%)</label>
                    <div class="relative">
                        <input class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-50/50" id="midterm" name="midterm" placeholder="0-100" type="number" step="0.01" min="0" max="100" value="{{ old('midterm', $grade?->midterm) }}"/>
                    </div>
                    @error('midterm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Final -->
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="final">Final (40%)</label>
                    <div class="relative">
                        <input class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-50/50" id="final" name="final" placeholder="0-100" type="number" step="0.01" min="0" max="100" value="{{ old('final', $grade?->final) }}"/>
                    </div>
                    @error('final') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Remarks Input -->
            <div class="space-y-1.5">
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="remarks">Status / Remarks (Optional override)</label>
                <select class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-50/50 appearance-none bg-no-repeat bg-[right_1rem_center]" id="remarks" name="remarks">
                    <option value="">Auto-calculate based on average</option>
                    <option value="Pass" {{ old('remarks', $grade?->remarks) === 'Pass' ? 'selected' : '' }}>Pass</option>
                    <option value="Fail" {{ old('remarks', $grade?->remarks) === 'Fail' ? 'selected' : '' }}>Fail</option>
                    <option value="Incomplete" {{ old('remarks', $grade?->remarks) === 'Incomplete' ? 'selected' : '' }}>Incomplete</option>
                    <option value="Dropped" {{ old('remarks', $grade?->remarks) === 'Dropped' ? 'selected' : '' }}>Dropped</option>
                </select>
                @error('remarks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

                <!-- Form Action Footer -->
                <div class="pt-10 flex justify-end border-t border-gray-100">
                    <button class="bg-[#0258E3] hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg flex items-center space-x-2 transition-all shadow-md active:scale-95" type="submit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        <span>Save Grade</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- END: GradeFormCard -->
</div>
@endsection
