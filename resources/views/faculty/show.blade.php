@extends('layouts.app')

@section('title', 'Faculty Profile')

@section('content')
<div class="max-w-4xl">
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('faculty.index') }}" class="flex items-center hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Back to Faculty
        </a>
        <span>›</span>
        <span class="font-medium text-gray-800">Faculty Profile</span>
    </nav>

    <div class="mb-10 flex justify-between items-end">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $faculty->user->name }}</h2>
            <p class="text-gray-500">Employee ID: <span class="font-mono font-bold text-blue-600">{{ $faculty->employee_id }}</span></p>
        </div>
        <a href="{{ route('faculty.edit', $faculty) }}" class="px-5 py-2.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-semibold hover:bg-amber-100 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Edit Profile
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-8">
            <section class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Departmental Information</h3>
                </div>
                <div class="p-8">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Assigned Department</p>
                        <p class="text-gray-900 font-semibold">{{ $faculty->department }}</p>
                    </div>
                </div>
            </section>

            <section class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Contact Details</h3>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Work Email</p>
                        <p class="text-blue-600 font-medium">{{ $faculty->user->email }}</p>
                    </div>
                </div>
            </section>

            <section class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Assigned Subjects</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] uppercase font-bold text-gray-400">
                            <tr>
                                <th class="px-8 py-3 tracking-wider">Subject Code</th>
                                <th class="px-8 py-3 tracking-wider">Description</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($faculty->subjects as $subject)
                            <tr>
                                <td class="px-8 py-4 font-mono text-sm text-blue-600">{{ $subject->subject_code }}</td>
                                <td class="px-8 py-4 text-sm text-gray-700">{{ $subject->description }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-8 py-10 text-center text-gray-500 italic">No subjects assigned yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="space-y-8">
            <section class="bg-slate-800 rounded-2xl p-6 text-white shadow-lg">
                <p class="text-xs uppercase tracking-widest text-slate-400 mb-2">Total Load</p>
                <h4 class="text-4xl font-bold">{{ $faculty->subjects->sum('units') }} <span class="text-lg font-normal text-slate-500">Units</span></h4>
            </section>
        </div>
    </div>
</div>
@endsection
