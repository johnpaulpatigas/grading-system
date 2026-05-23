<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>CPC Portal - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-active { background-color: rgba(255, 255, 255, 0.1); border-left: 4px solid #3b82f6; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #CBD5E0; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#1a1c23] text-gray-400 flex flex-col h-full">
        <div class="p-6 flex items-center gap-3">
            <img alt="CPC Logo" class="w-10 h-10 object-contain rounded-full bg-white p-0.5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5MdWhunn_mmZD54EDZCmsylN7-pZ81bM9pf5PVpPUfMQWXnwtb-G6ZJ-T0mehVznCi9Bd_DYjeTQyg1dpxyuSP4VntB8hQA9MZ1LTRDn3vyuArr_Cz_o86JqavmaKA_ecfuKmA3Xlzlf39nbpExrYeXA57PfSzI2k3oC_Wab8z8Hzwra2cYxI7xlzPFSvpqo9C0aSIsn2gKRMlU-pRQ78VI0BI2YK6-IV_hMqnKL9Ofvn7aCMDrgI0OAqcXJpQgFdIwFqYWqqGdY"/>
            <div>
                <h1 class="text-white font-bold text-lg leading-tight">CPC Portal</h1>
                <p class="text-xs text-gray-500">{{ Auth::user()->role === 'admin' ? 'Registrar Office' : (Auth::user()->role === 'faculty' ? 'Faculty Portal' : 'Student Portal') }}</p>
            </div>
        </div>
        <nav class="flex-1 px-4 mt-4 space-y-1 overflow-y-auto custom-scrollbar">
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="{{ route('dashboard') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Dashboard</span>
            </a>
            @if(Auth::user()->isAdmin())
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('students*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="#">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Students</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('faculty*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="#">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Faculty</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('subjects*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="#">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Subjects</span>
            </a>
            @endif
            @if(Auth::user()->isAdmin() || Auth::user()->isFaculty())
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('grading*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="#">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Grading</span>
            </a>
            @endif
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->is('reports*') ? 'text-white sidebar-active' : 'hover:bg-white/5 hover:text-white' }} rounded-lg transition-colors" href="#">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Reports</span>
            </a>
        </nav>
        <div class="p-4 border-t border-gray-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-white/5 hover:text-white rounded-lg transition-colors text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <div class="flex-1 max-w-2xl relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </span>
                <input class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-full bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm" placeholder="Search..." type="text"/>
            </div>
            <div class="flex items-center gap-4 ml-6">
                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                <img class="h-8 w-8 rounded-full border border-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="">
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            @yield('content')
        </div>
    </main>
</body>
</html>
