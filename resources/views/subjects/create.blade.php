@extends('layouts.app')

@section('title', 'Add Subject')

@section('content')
<!-- BEGIN: Form Page Content -->
<div class="max-w-7xl mx-auto w-full">
    <!-- BEGIN: Page Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <nav class="flex items-center text-sm text-gray-500 mb-2">
                <a class="flex items-center hover:text-blue-600 transition-colors" href="{{ route('subjects.index') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    Go Back
                </a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-900 font-medium">Add Subject</span>
            </nav>
            <h2 class="text-4xl font-bold text-[#111827]">Curriculum Form</h2>
            <p class="text-[#6B7280] mt-2">Register a new academic subject into the central institutional database.</p>
        </div>
    </div>
    <!-- END: Page Header -->

    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf
        <div class="flex items-center justify-end gap-3 mb-8">
            <a href="{{ route('subjects.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-[#0047AB] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition-colors shadow-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                Save Subject
            </button>
        </div>

        <!-- BEGIN: Layout Columns -->
        <div class="grid grid-cols-12 gap-8">
            <!-- BEGIN: Left Column -->
            <div class="col-span-12 lg:col-span-8 space-y-8">
                <!-- BEGIN: Core Information Card -->
                <section class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Core Information</h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Subject Code -->
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Subject Code <span class="text-red-500">*</span></label>
                                <input class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 bg-gray-50/50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" name="subject_code" placeholder="e.g., CS101" type="text" value="{{ old('subject_code') }}" required/>
                                @error('subject_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Units / Credits -->
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Units / Credits <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 bg-gray-50/50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" name="units" placeholder="3" type="number" step="0.5" value="{{ old('units') }}" required/>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 font-medium">Credits</span>
                                </div>
                                @error('units') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <!-- Subject Title / Description -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Subject Title <span class="text-red-500">*</span></label>
                            <input class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 bg-gray-50/50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all" name="description" placeholder="Introduction to Computer Science" type="text" value="{{ old('description') }}" required/>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>
                <!-- END: Core Information Card -->
            </div>

            <!-- BEGIN: Right Column -->
            <div class="col-span-12 lg:col-span-4 space-y-8">
                <!-- BEGIN: Prerequisites Card -->
                <section class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Prerequisites</h3>
                    </div>
                    <div class="p-6 space-y-6 text-center py-12">
                        <div class="text-gray-300 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                        </div>
                        <h4 class="text-sm font-semibold text-gray-500">No prerequisites added yet.</h4>
                        <p class="text-xs text-gray-400 mt-1">This subject will be open to all eligible students.</p>
                    </div>
                </section>
                <!-- END: Prerequisites Card -->
            </div>
        </div>
    </form>
</div>
@endsection
