@extends('layouts.app')

@section('title', 'Encode Grade')

@section('content')
<nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('grading.index', ['subject_id' => $subject->id]) }}" class="flex items-center hover:text-gray-800 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Go Back
    </a>
    <span>›</span>
    <span class="font-medium text-gray-800">Encode Grade</span>
</nav>

<div class="mb-10">
    <h2 class="text-3xl font-bold text-gray-900 mb-1">Encode Student Grade</h2>
    <p class="text-gray-500">Entering grade for {{ $student->user->name }} in {{ $subject->subject_code }}.</p>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden max-w-2xl">
    <div class="p-8">
        <form action="{{ route('grading.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
            
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="grade">Numeric Grade (0-100) <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="grade" name="grade" placeholder="e.g. 85.5" type="number" step="0.01" min="0" max="100" value="{{ old('grade', $grade?->grade) }}" required/>
                    @error('grade') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="remarks">Remarks</label>
                    <textarea class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="remarks" name="remarks" placeholder="Optional remarks...">{{ old('remarks', $grade?->remarks) }}</textarea>
                    @error('remarks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 flex justify-end">
                <button class="bg-[#0258E3] hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg flex items-center space-x-2 transition-all" type="submit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <span>Save Grade</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
