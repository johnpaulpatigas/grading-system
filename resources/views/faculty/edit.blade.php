@extends('layouts.app')

@section('title', 'Edit Teacher Record')

@section('content')
<nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('faculty.index') }}" class="flex items-center hover:text-gray-800 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Go Back
    </a>
    <span>›</span>
    <span class="font-medium text-gray-800">Edit Teacher</span>
</nav>

<div class="mb-10">
    <h2 class="text-3xl font-bold text-gray-900 mb-1">Edit Teacher Record</h2>
    <p class="text-gray-500">Update teacher entry for the grading system.</p>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="p-8">
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Personal Faculty Information</h3>
                <p class="text-sm text-gray-500">Update official legal details and contact information.</p>
            </div>
        </div>

        <form action="{{ route('faculty.update', $faculty) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="name">Full Name <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="name" name="name" placeholder="e.g. Dr. Jane Doe" type="text" value="{{ old('name', $faculty->user->name) }}" required/>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="email">Email Address <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="email" name="email" placeholder="jane@university.edu" type="email" value="{{ old('email', $faculty->user->email) }}" required/>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="employee_id">Employee ID <span class="text-red-500">*</span></label>
                    <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="employee_id" name="employee_id" placeholder="EMP-0001" type="text" value="{{ old('employee_id', $faculty->employee_id) }}" required/>
                    @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="department">Department <span class="text-red-500">*</span></label>
                    <select class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-gray-600" id="department" name="department" required>
                        <option value="">Select Department</option>
                        <option value="College of Computer Studies" {{ old('department', $faculty->department) == 'College of Computer Studies' ? 'selected' : '' }}>College of Computer Studies</option>
                        <option value="College of Business & Education" {{ old('department', $faculty->department) == 'College of Business & Education' ? 'selected' : '' }}>College of Business & Education</option>
                    </select>
                    @error('department') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-1.5 pt-6">
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="subject_ids">Assigned Subjects</label>
                <select class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="subject_ids" name="subject_ids[]" multiple>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ in_array($subject->id, old('subject_ids', $faculty->subjects->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $subject->subject_code }} - {{ $subject->description }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl (Windows) or Cmd (Mac) to select multiple subjects.</p>
                @error('subject_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-10 flex justify-end">
                <button class="bg-[#0047cc] hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg flex items-center space-x-2 transition-all" type="submit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <span>Update Record</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
