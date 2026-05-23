@extends('layouts.app')

@section('title', 'Subject Details')

@section('content')
<div class="max-w-4xl">
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('subjects.index') }}" class="flex items-center hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Back to Curriculum
        </a>
        <span>›</span>
        <span class="font-medium text-gray-800">Subject Details</span>
    </nav>

    <div class="mb-10 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $subject->description }}</h2>
            <p class="text-gray-500">Subject Code: <span class="font-mono font-bold text-blue-600">{{ $subject->subject_code }}</span></p>
        </div>
        <a href="{{ route('subjects.edit', $subject) }}" class="px-5 py-2.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-semibold hover:bg-amber-100 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Edit Subject
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-8">
            <section class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Curriculum Information</h3>
                </div>
                <div class="p-8 grid grid-cols-2 gap-8">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Credit Units</p>
                        <p class="text-gray-900 font-semibold">{{ number_format($subject->units, 1) }} Units</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Assigned Teachers</p>
                        <p class="text-gray-900 font-semibold">{{ $subject->faculties->count() }}</p>
                    </div>
                </div>
            </section>

            <section class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Prerequisites</h3>
                </div>
                <div class="p-8">
                    @forelse($subject->prerequisites as $pre)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-100 mb-2">
                            <span class="font-mono font-bold text-xs text-blue-600">{{ $pre->subject_code }}</span>
                            <span class="text-sm text-gray-700">{{ $pre->description }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 italic text-sm text-center py-4">No prerequisites required for this subject.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="space-y-8">
            <section class="bg-blue-50 rounded-2xl p-6 border border-blue-100 shadow-sm">
                <p class="text-xs uppercase tracking-widest text-blue-400 font-bold mb-4">Enrollment Summary</p>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Enrolled</span>
                        <span class="font-bold text-gray-900">{{ $subject->students->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Passed</span>
                        <span class="font-bold text-emerald-600">{{ $subject->grades->where('average', '>=', 75)->count() }}</span>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
