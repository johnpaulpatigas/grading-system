@extends('layouts.app')

@section('title', 'Edit Teacher Record')

@section('content')
<div class="max-w-4xl mx-auto">
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
        <a class="flex items-center hover:text-gray-800 transition-colors" href="{{ route('faculty.index') }}">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Go Back
        </a>
    </nav>

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Edit Teacher Record</h2>
        <p class="text-gray-500">Update teacher entry for the grading system.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-8">
            <form action="{{ route('faculty.update', $faculty) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="name">Full Name <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" id="name" name="name" type="text" value="{{ old('name', $faculty->user->name) }}" required/>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="email">Email Address <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" id="email" name="email" type="email" value="{{ old('email', $faculty->user->email) }}" required/>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="employee_id_suffix">Employee ID <span class="text-red-500">*</span></label>
                        <div class="flex items-center w-full border border-gray-300 rounded-lg overflow-hidden bg-gray-50 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500 transition-all flex-nowrap">
                            <span class="px-3 py-3 text-sm text-gray-500 font-bold bg-gray-100 border-r border-gray-300 select-none whitespace-nowrap">FAC-2026-</span>
                            <input class="w-full px-4 py-3 text-sm bg-transparent border-none focus:outline-none" id="employee_id_suffix" maxlength="3" placeholder="001" type="text" value="{{ old('employee_id') ? substr(old('employee_id'), 9) : substr($faculty->employee_id, 9) }}" required/>
                        </div>
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ old('employee_id', $faculty->employee_id) }}"/>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider" for="department">Department <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm" id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="College of Computer Studies" {{ old('department', $faculty->department) == 'College of Computer Studies' ? 'selected' : '' }}>College of Computer Studies</option>
                            <option value="College of Business & Education" {{ old('department', $faculty->department) == 'College of Business & Education' ? 'selected' : '' }}>College of Business & Education</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2 pt-4">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Assigned Subjects</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-4 border border-gray-300 rounded-lg bg-gray-50 max-h-64 overflow-y-auto">
                        @foreach($subjects as $subject)
                            <label class="flex items-center space-x-3 p-3 bg-white border border-gray-200 rounded-lg hover:border-blue-400 cursor-pointer transition-all">
                                <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" class="text-blue-600 focus:ring-blue-500 rounded border-gray-300" {{ in_array($subject->id, old('subject_ids', $faculty->subjects->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">{{ $subject->subject_code }} - {{ $subject->description }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-all" type="submit">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const suffixInput = document.getElementById('employee_id_suffix');
    const hiddenInput = document.getElementById('employee_id');
    const prefix = "FAC-2026-";
    function updateFullId() {
        const suffix = suffixInput.value.replace(/[^0-9]/g, '');
        suffixInput.value = suffix;
        hiddenInput.value = prefix + suffix.padStart(3, '0');
    }
    suffixInput.addEventListener('input', updateFullId);
    updateFullId();
</script>
@endsection
