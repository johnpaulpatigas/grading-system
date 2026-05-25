@extends('layouts.app')

@section('title', 'Add Teacher Record')

@section('content')
<!-- BEGIN: PageContent -->
<div class="max-w-4xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a class="flex items-center hover:text-gray-800 transition-colors" href="{{ route('faculty.index') }}">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Go Back
        </a>
        <span>›</span>
        <span class="font-medium text-gray-800">Add Teacher</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-1">Add Teacher Record</h2>
        <p class="text-gray-500">Create a new teacher entry for the grading system.</p>
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
                    <h3 class="text-xl font-bold text-gray-900">Personal Teacher Information</h3>
                    <p class="text-sm text-gray-500">Enter official legal details and contact information.</p>
                </div>
            </div>

            <!-- Form Fields Grid -->
            <form action="{{ route('faculty.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Name -->
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

                    <!-- Employee ID -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="employee_id">Employee ID <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="employee_id" name="employee_id" maxlength="12" placeholder="FAC-2026-001" type="text" value="{{ old('employee_id', 'FAC-2026-') }}" required/>
                        @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <script>
                        const empInput = document.getElementById('employee_id');
                        const prefix = "FAC-2026-";
                        empInput.addEventListener('input', () => {
                            if (!empInput.value.startsWith(prefix)) {
                                empInput.value = prefix + empInput.value.replace(prefix, '');
                            }
                        });
                    </script>

                    <!-- Department -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="department">Department <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm text-gray-600 appearance-none bg-none bg-no-repeat bg-position-[right_1rem_center]" id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="College of Computer Studies" {{ old('department') === 'College of Computer Studies' ? 'selected' : '' }}>College of Computer Studies</option>
                            <option value="College of Business & Education" {{ old('department') === 'College of Business & Education' ? 'selected' : '' }}>College of Business & Education</option>
                        </select>
                        @error('department') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider" for="subject_ids">Assigned Subjects</label>
                    <select class="w-full px-4 py-3 rounded-lg border-gray-200 focus:border-blue-500 focus:ring-blue-500 text-sm" id="subject_ids" name="subject_ids[]" multiple>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ in_array($subject->id, old('subject_ids', [])) ? 'selected' : '' }}>
                                {{ $subject->subject_code }} - {{ $subject->description }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Hold Ctrl (Windows) or Cmd (Mac) to select multiple subjects.</p>
                    @error('subject_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
@endsection
