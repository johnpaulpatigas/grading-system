<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Register - Cordova Public College Kiosk</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .custom-shadow { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <main class="w-full max-w-6xl flex flex-col md:flex-row bg-white rounded-2xl overflow-hidden custom-shadow min-h-[800px]">
        <!-- Left Sidebar (Branding) -->
        <section class="w-full md:w-[40%] bg-[#121926] p-8 md:p-12 flex flex-col justify-between text-white relative overflow-hidden">
            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-900 rounded-full blur-[100px] opacity-20"></div>
            <div class="relative z-10">
                <header class="flex items-center gap-3 mb-16">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center overflow-hidden">
                        <img alt="CPC Logo" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRSwD6eREkGiHMbd6FGRDdWOdOvp-zLefPfTuLkEk6z8O7QSj5bPCfNTJyj8YhGJ1YsRu_J8Tror_8qy-raFrD9SW8bk8_5wa0J6hv6vkWXR2uElEWHl6iRlOO9o_mfKERUBpzXf51t2u4oh05LwynEwQ0nTAKeWoDLbt8Kfn5HLgFNHzi1Q3k9SIR99UhOw9wxw3hroTp2b8Z8bqhvPnEVJk1YgVrKD_xr-CfiDEsXvJDjIlWk2ksPqkGRuH5WkTXUzQ7X7yW7F0"/>
                    </div>
                    <h1 class="font-bold text-lg tracking-tight">Cordova Public College Kiosk</h1>
                </header>
                <div class="space-y-6">
                    <h2 class="text-4xl font-bold leading-tight">Join the<br/>Academic Portal.</h2>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm">Create your student account to access grades, enrollment records, and institutional resources.</p>
                </div>
            </div>
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

        <!-- Right Content (Registration Form) -->
        <section class="w-full md:w-[60%] p-8 md:p-12 flex flex-col justify-center bg-white overflow-y-auto">
            <div class="w-full max-w-2xl mx-auto">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Student Account</h2>
                    <p class="text-gray-500 text-sm">Fill in your details to register for the grading portal.</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Full Name -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="name">Full Name</label>
                            <input class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition-all" id="name" name="name" placeholder="John Doe" type="text" value="{{ old('name') }}" required/>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="email">Email Address</label>
                            <input class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition-all" id="email" name="email" placeholder="john@example.com" type="email" value="{{ old('email') }}" required/>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Student ID -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="student_id">Student ID</label>
                            <input class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition-all" id="student_id" name="student_id" placeholder="2023-0001" type="text" value="{{ old('student_id') }}" required/>
                            @error('student_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Course -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="course">Course</label>
                            <input class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition-all" id="course" name="course" placeholder="BS Computer Science" type="text" value="{{ old('course') }}" required/>
                            @error('course') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Year Level -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="year_level">Year Level</label>
                            <select class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition-all" id="year_level" name="year_level" required>
                                <option value="">Select Year</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                            @error('year_level') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Section -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="section">Section</label>
                            <input class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition-all" id="section" name="section" placeholder="A-1" type="text" value="{{ old('section') }}" required/>
                            @error('section') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="password">Password</label>
                            <input class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition-all" id="password" name="password" placeholder="••••••••" type="password" required/>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider" for="password_confirmation">Confirm Password</label>
                            <input class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition-all" id="password_confirmation" name="password_confirmation" placeholder="••••••••" type="password" required/>
                        </div>
                    </div>

                    <button class="w-full bg-[#0052cc] hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-blue-200 transition-all active:scale-[0.98] mt-4" type="submit">
                        Create Account
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Log in here</a></p>
                </div>

                <footer class="mt-8 text-center">
                    <p class="text-[10px] text-gray-400 uppercase tracking-wide">Authorized personnel only. @CPC_IPT_HCI_PROJECT_2026</p>
                </footer>
            </div>
        </section>
    </main>
</body>
</html>
