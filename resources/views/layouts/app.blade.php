<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>CPC Portal - @yield('title', 'Dashboard')</title>
    <!-- Tailwind CSS v3 CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Google Fonts for Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style data-purpose="typography">
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <style data-purpose="custom-layout">
        .sidebar-active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #3b82f6;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #CBD5E0;
            border-radius: 10px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">
    <!-- BEGIN: LeftSidebar -->
    <aside class="w-64 bg-[#1a1c23] text-gray-400 flex flex-col h-full" data-purpose="main-sidebar">
        <!-- Sidebar Logo Section -->
        <div class="p-6 flex items-center gap-3">
            <img alt="CPC Logo" class="w-10 h-10 object-contain rounded-full bg-white p-0.5" data-purpose="logo" src="{{ asset('cpclogo.png') }}"/>
            <div>
                <h1 class="text-white font-bold text-lg leading-tight">CPC Portal</h1>
                <p class="text-xs text-gray-500">{{ Auth::user()->role === 'admin' ? 'Registrar Office' : (Auth::user()->role === 'faculty' ? 'Faculty Portal' : 'Student Portal') }}</p>
            </div>
        </div>
        <!-- Main Navigation -->
        <nav class="flex-1 px-4 mt-4 space-y-1 overflow-y-auto custom-scrollbar" data-purpose="sidebar-navigation">
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="{{ route('dashboard') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Dashboard</span>
            </a>
            @if(Auth::user()->isAdmin())
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('students*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="{{ route('students.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Students</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('faculty*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="{{ route('faculty.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Faculty</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('subjects*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="{{ route('subjects.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Subjects</span>
            </a>
            @endif
            @if(Auth::user()->isAdmin() || Auth::user()->isFaculty())
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('grading*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="{{ route('grading.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Grading</span>
            </a>
            @endif
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('reports*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="{{ route('reports.index') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Reports</span>
            </a>
        </nav>
        <!-- Action Button -->
        @if(Auth::user()->isAdmin())
        <div class="px-4 mb-6">
            <a href="{{ route('enrollments.create') }}" class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all active:scale-95 shadow-lg shadow-blue-900/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                New Enrollment
            </a>
        </div>
        @endif
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-800" data-purpose="sidebar-footer">
            <a class="flex items-center gap-3 px-4 py-3 hover:bg-white/5 hover:text-white rounded-lg transition-colors" href="#">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Help Center</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-white/5 hover:text-white rounded-lg transition-colors text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
    <!-- END: LeftSidebar -->

    <!-- BEGIN: MainContent -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Top Header Bar -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between" data-purpose="top-header">
            <div class="flex-1 max-w-2xl relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </span>
                <input class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-full bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm" placeholder="Search records, students, or grades..." type="text"/>
            </div>
            <div class="flex items-center gap-6 ml-6">
                <button class="text-gray-400 hover:text-gray-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </button>
                <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <img class="h-10 w-10 rounded-full border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0052cc&color=fff" alt="">
                </div>
            </div>
        </header>

        <!-- Scrollable Dashboard Content -->
        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            @yield('content')
        </div>
    </main>
    <!-- END: MainContent -->
    @include('partials.flash-messages')
    @stack('scripts')
</body>
</html>

