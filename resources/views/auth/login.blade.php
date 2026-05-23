<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - Cordova Public College Kiosk</title>
    <!-- Tailwind CSS v3 CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style data-purpose="typography">
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <style data-purpose="custom-styling">
        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }
        .custom-shadow {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
<!-- BEGIN: Main Login Container -->
<main class="w-full max-w-6xl flex flex-col md:flex-row bg-white rounded-2xl overflow-hidden custom-shadow min-h-[700px]" data-purpose="login-card">
    <!-- BEGIN: Left Sidebar (Branding) -->
    <section class="w-full md:w-[45%] bg-[#121926] p-8 md:p-12 flex flex-col justify-between text-white relative overflow-hidden" data-purpose="branding-sidebar">
        <!-- Decorative background glow -->
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-900 rounded-full blur-[100px] opacity-20"></div>
        <div class="relative z-10">
            <!-- Logo Header -->
            <header class="flex items-center gap-3 mb-16">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center overflow-hidden">
                    <!-- CPC Logo Placeholder -->
                    <img alt="CPC Logo" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRSwD6eREkGiHMbd6FGRDdWOdOvp-zLefPfTuLkEk6z8O7QSj5bPCfNTJyj8YhGJ1YsRu_J8Tror_8qy-raFrD9SW8bk8_5wa0J6hv6vkWXR2uElEWHl6iRlOO9o_mfKERUBpzXf51t2u4oh05LwynEwQ0nTAKeWoDLbt8Kfn5HLgFNHzi1Q3k9SIR99UhOw9wxw3hroTp2b8Z8bqhvPnEVJk1YgVrKD_xr-CfiDEsXvJDjIlWk2ksPqkGRuH5WkTXUzQ7X7yW7F0"/>
                </div>
                <h1 class="font-bold text-lg tracking-tight">Cordova Public College Kiosk</h1>
            </header>
            <!-- Marketing Copy -->
            <div class="space-y-6">
                <h2 class="text-4xl md:text-5xl font-bold leading-tight">
                    Integrity in Every<br/>Evaluation Stage.
                </h2>
                <p class="text-gray-400 text-sm md:text-base leading-relaxed max-w-sm">
                    Access the centralized Registrar Grading System. Manage academic transcripts, verify student credits, and maintain institutional standards with surgical precision.
                </p>
            </div>
            <!-- Featured Image Area -->
            <div class="mt-12 rounded-xl overflow-hidden grayscale border border-white/10">
                <!-- Institutional Group Photo -->
                <img alt="Institutional History Photo" class="w-full h-auto object-cover opacity-80" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDC--SaMOY2-tj9ZHf0A6Jcdp9zFSGAqLUuDLuh8BjyDLbcgxsXRIByffRPj5DtPekDj0tfKyy8yiXt-2LPBQAwP9iBfivxDU5K0A2MPygst0pgS1StRd2NXHUA_BGQG5ar55vFPaM551BTCA3rxcRvxFy-aLJHvwj0X0pEKfmHJWOr01lbkjbWRTOvF4pksAvJdxnFHvGIesCsBqeTgG8f0GpusF07Qie08hp-i1K8QYkk-KqHwbnoWaQmtMDrsWEsSPhcA3r2BHg"/>
            </div>
        </div>
        <!-- Left Column Footer Stats -->
        <footer class="mt-12 flex gap-12 relative z-10">
            <div class="space-y-1">
                <div class="text-xl font-bold">2005</div>
                <div class="text-[10px] uppercase tracking-widest text-gray-500 font-semibold">Institutional History</div>
            </div>
            <div class="w-px h-10 bg-gray-700 self-center"></div>
            <div class="space-y-1">
                <div class="text-xl font-bold">2025</div>
                <div class="text-[10px] uppercase tracking-widest text-gray-500 font-semibold">Quality Certified</div>
            </div>
        </footer>
    </section>
    <!-- END: Left Sidebar -->
    <!-- BEGIN: Right Content (Login Form) -->
    <section class="w-full md:w-[55%] p-8 md:p-16 flex flex-col justify-center items-center bg-white" data-purpose="login-form-container">
        <div class="w-full max-w-md">
            <!-- Form Header -->
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Want to know your grades?</h2>
                <p class="text-gray-500 text-sm">Enter your credentials to access the grading portal.</p>
            </div>
            <!-- Credentials Form -->
            <form action="{{ route('login') }}" class="space-y-6" data-purpose="student-login-form" method="POST">
                @csrf
                <!-- Student ID Input -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="student_id">Student ID</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <!-- ID Card Icon -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </span>
                        <input class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-all" id="student_id" name="student_id" placeholder="20230753" type="text" value="{{ old('student_id') }}" required autofocus/>
                    </div>
                    @error('student_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="password">Password</label>
                        <a class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors" href="#">Forgot Password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <!-- Lock Icon -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </span>
                        <input class="block w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-gray-900 transition-all" id="password" name="password" placeholder="••••••••" type="password" required/>
                        <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" type="button">
                            <!-- Eye Icon -->
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Submit Button -->
                <button class="w-full bg-[#0052cc] hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-lg shadow-lg shadow-blue-200 transition-all active:scale-[0.98]" type="submit">
                    Log-in
                </button>
            </form>
            
            <!-- Divider Section -->
            <div class="relative my-10">
                <div aria-hidden="true" class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-white px-4 text-gray-400 font-bold tracking-widest">Faculty/Staff Only</span>
                </div>
            </div>
            
            <!-- SSO Button -->
            <button class="w-full flex items-center justify-center gap-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 px-4 rounded-lg transition-all" data-purpose="google-login" type="button">
                <!-- Google Logo Placeholder -->
                <div class="w-5 h-5 bg-white border border-gray-100 rounded flex items-center justify-center shadow-sm">
                    <svg height="16" viewbox="0 0 24 24" width="16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"></path>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 12-5.38z" fill="#EA4335"></path>
                    </svg>
                </div>
                Sign in with Work Email
            </button>

            <!-- Compliance Footer -->
            <footer class="mt-12 text-center space-y-4">
                <p class="text-[10px] text-gray-400 leading-relaxed uppercase tracking-wide">
                    Authorized personnel only. All access attempts are<br/>logged for audit compliance.
                </p>
                <p class="text-[10px] font-bold text-blue-600 tracking-wider">
                    @CPC_IPT_HCI_PROJECT_2026
                </p>
            </footer>
        </div>
    </section>
    <!-- END: Right Content -->
</main>
<!-- END: Main Login Container -->
</body>
</html>