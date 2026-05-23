@extends('layouts.app')

@section('title', 'Add New Subject')

@section('content')
<nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('subjects.index') }}" class="flex items-center hover:text-gray-800 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Go Back
    </a>
    <span>›</span>
    <span class="font-medium text-gray-800">Add Subject</span>
</nav>

<div class="mb-10">
    <h2 class="text-3xl font-bold text-gray-900 mb-1">Add Academic Subject</h2>
    <p class="text-gray-500">Configure a new subject for the curriculum database.</p>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden max-w-2xl">
    <div class="p-8">
        <form action="{{ route('subjects.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="subject_code">Subject Code <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="subject_code" name="subject_code" placeholder="e.g. CS-402" type="text" value="{{ old('subject_code') }}" required/>
                    @error('subject_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="description">Description <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="description" name="description" placeholder="e.g. Advanced Algorithms" type="text" value="{{ old('description') }}" required/>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="units">Units <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="units" name="units" placeholder="e.g. 3" type="number" min="1" max="10" value="{{ old('units') }}" required/>
                    @error('units') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 flex justify-end">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg flex items-center space-x-2 transition-all" type="submit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <span>Save Subject</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
