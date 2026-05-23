@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Page Title -->
<div class="mb-8" data-purpose="dashboard-header">
    <h2 class="text-3xl font-bold text-gray-900">Registrar Dashboard</h2>
    <p class="text-gray-500 mt-1">Real-time overview of academic records and institutional performance.</p>
</div>

<!-- BEGIN: SummaryCards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" data-purpose="stat-cards-container">
    <!-- Total Students Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Students</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($totalStudents) }}</span>
                <span class="text-xs font-semibold text-green-500">Live</span>
            </div>
        </div>
        <a href="{{ route('students.create') }}" class="mt-6 w-full py-2.5 bg-[#0052cc] text-white rounded-lg flex items-center justify-center gap-2 text-sm font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Add Student
        </a>
    </div>
    <!-- Total Subjects Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Subjects</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-bold text-gray-900">{{ $totalSubjects }}</span>
                <span class="text-xs font-semibold text-gray-400">Active</span>
            </div>
        </div>
        <a href="{{ route('subjects.create') }}" class="mt-6 w-full py-2.5 bg-[#0052cc] text-white rounded-lg flex items-center justify-center gap-2 text-sm font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Add Subject
        </a>
    </div>
    <!-- Encoded Grades Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Encoded Grades</span>
            <div class="flex items-center gap-4 mt-1">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($encodingProgress, 0) }}%</span>
                <div class="flex-1 bg-gray-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-500 h-full rounded-full" style="width: {{ $encodingProgress }}%"></div>
                </div>
            </div>
        </div>
        <a href="{{ route('faculty.create') }}" class="mt-6 w-full py-2.5 bg-[#0052cc] text-white rounded-lg flex items-center justify-center gap-2 text-sm font-semibold hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            Add Teacher
        </a>
    </div>
    <!-- Passing Rate Card -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Passing Rate</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($passingRate, 0) }}%</span>
                <div class="flex items-center gap-1 text-xs font-semibold text-green-500">
                    <svg class="w-3 h-3" fill="currentColor" viewbox="0 0 20 20"><path clip-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" fill-rule="evenodd"></path></svg>
                    Calculated
                </div>
            </div>
        </div>
        <div class="mt-6 flex items-center h-10">
            <!-- Space matching the buttons height -->
        </div>
    </div>
</div>
<!-- END: SummaryCards -->

<!-- BEGIN: ChartsSection -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" data-purpose="charts-row">
    <!-- Grading Progress Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-[400px]">
        <div class="px-6 py-4 flex items-center justify-between border-b border-gray-50">
            <h3 class="font-bold text-gray-800">Grading Progress</h3>
            <span class="text-xs px-2.5 py-1 bg-gray-50 text-gray-500 rounded-md font-medium border border-gray-100">Last 30 Days</span>
        </div>
        <div class="flex-1 p-6 relative">
            <canvas class="w-full h-full" data-purpose="line-chart-canvas" id="gradingProgressChart"></canvas>
            <div class="absolute bottom-6 left-10 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                <span class="text-xs font-medium text-gray-500">Encoded Grades</span>
            </div>
        </div>
    </div>
    <!-- Grade Distribution Chart -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-[400px]">
        <div class="px-6 py-4 border-b border-gray-50">
            <h3 class="font-bold text-gray-800">Grade Distribution</h3>
        </div>
        <div class="flex-1 flex flex-col items-center justify-center p-6">
            <div class="relative w-48 h-48 mb-8" data-purpose="donut-chart-container">
                @php
                    $dash1 = ($distPercents['passing'] / 100) * 251;
                    $dash2 = ($distPercents['conditional'] / 100) * 251;
                    $dash3 = ($distPercents['failing'] / 100) * 251;
                    $offset1 = 0;
                    $offset2 = -$dash1;
                    $offset3 = -($dash1 + $dash2);
                @endphp
                <svg class="w-full h-full" viewbox="0 0 100 100">
                    <circle cx="50" cy="50" fill="none" r="40" stroke="#f3f4f6" stroke-width="12"></circle>
                    <circle cx="50" cy="50" fill="none" r="40" stroke="#3b82f6" stroke-dasharray="{{ $dash1 }} 251" stroke-dashoffset="{{ $offset1 }}" stroke-width="12" transform="rotate(-90 50 50)"></circle>
                    <circle cx="50" cy="50" fill="none" r="40" stroke="#64748b" stroke-dasharray="{{ $dash2 }} 251" stroke-dashoffset="{{ $offset2 }}" stroke-width="12" transform="rotate(-90 50 50)"></circle>
                    <circle cx="50" cy="50" fill="none" r="40" stroke="#ef4444" stroke-dasharray="{{ $dash3 }} 251" stroke-dashoffset="{{ $offset3 }}" stroke-width="12" transform="rotate(-90 50 50)"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                    <span class="text-2xl font-bold text-gray-900">{{ $distTotal >= 1000 ? number_format($distTotal/1000, 1) . 'k' : $distTotal }}</span>
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-tighter">Total Grades</span>
                </div>
            </div>
            <div class="w-full space-y-3" data-purpose="chart-legend">
                <div class="flex items-center justify-between text-xs font-medium">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span class="text-gray-600">Passing (<= 3.0)</span>
                    </div>
                    <span class="text-gray-900">{{ $distPercents['passing'] }}%</span>
                </div>
                <div class="flex items-center justify-between text-xs font-medium">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-500"></span>
                        <span class="text-gray-600">Conditional (3.1 - 4.0)</span>
                    </div>
                    <span class="text-gray-900">{{ $distPercents['conditional'] }}%</span>
                </div>
                <div class="flex items-center justify-between text-xs font-medium">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                        <span class="text-gray-600">Failing (> 4.0 / Fail)</span>
                    </div>
                    <span class="text-gray-900">{{ $distPercents['failing'] }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: ChartsSection -->
@endsection

@push('scripts')
<script data-purpose="canvas-setup">
    const canvas = document.getElementById('gradingProgressChart');
    const chartData = @json($dailyProgress);
    
    if (canvas) {
      const ctx = canvas.getContext('2d');
      const resizeCanvas = () => {
        canvas.width = canvas.parentElement.clientWidth;
        canvas.height = canvas.parentElement.clientHeight - 40;
        drawChart();
      };

      const drawChart = () => {
        const w = canvas.width;
        const h = canvas.height;
        const maxVal = Math.max(...chartData, 5); // Ensure a minimum scale
        ctx.clearRect(0, 0, w, h);

        ctx.beginPath();
        const stepX = w / (chartData.length - 1);
        
        chartData.forEach((val, i) => {
            const x = i * stepX;
            const y = h - (val / maxVal * h * 0.8) - (h * 0.1);
            if (i === 0) ctx.moveTo(x, y);
            else ctx.lineTo(x, y);
        });
        
        ctx.lineWidth = 4;
        ctx.strokeStyle = '#2563eb';
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.stroke();

        // Fill below
        ctx.lineTo(w, h);
        ctx.lineTo(0, h);
        ctx.closePath();
        const gradient = ctx.createLinearGradient(0, 0, 0, h);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.08)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');
        ctx.fillStyle = gradient;
        ctx.fill();

        // Points
        chartData.forEach((val, i) => {
            const x = i * stepX;
            const y = h - (val / maxVal * h * 0.8) - (h * 0.1);
            ctx.beginPath();
            ctx.arc(x, y, 4, 0, Math.PI * 2);
            ctx.fillStyle = '#2563eb';
            ctx.fill();
            ctx.strokeStyle = '#fff';
            ctx.lineWidth = 2;
            ctx.stroke();
        });
      };

      window.addEventListener('resize', resizeCanvas);
      resizeCanvas();
    }
</script>
@endpush
