<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'EduLMS'))</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tailwind & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-[#e3000f] rounded-lg flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-red-500/20">
                            A
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900 hidden sm:block">THE ACE <span class="text-[#e3000f]">INDIA</span></span>
                    </a>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-sm font-semibold text-slate-600 hover:text-[#e3000f] transition-colors">Home</a>
                    <a href="{{ route('courses.index') }}" class="text-sm font-semibold text-slate-600 hover:text-[#e3000f] transition-colors">Courses</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-[#e3000f] transition-colors">My Dashboard</a>
                        <div class="h-6 w-px bg-slate-200"></div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <div class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</div>
                                <div class="text-[11px] text-[#e3000f] font-bold uppercase tracking-wider mt-1">
                                    {{ Auth::user()->is_admin ? 'Admin' : (Auth::user()->is_trainer ? 'Trainer' : 'Student') }}
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="p-2 text-slate-400 hover:text-[#e3000f] transition-colors">
                                    <i class="bi bi-box-arrow-right text-xl"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-[#e3000f] transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="bg-[#e3000f] text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-[#cc0000] transition-all shadow-md shadow-red-500/20">Get Started</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-500 p-2">
                        <i class="bi bi-list text-2xl" x-show="!mobileMenuOpen"></i>
                        <i class="bi bi-x-lg text-2xl" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden bg-white border-b border-slate-200" x-show="mobileMenuOpen" x-cloak x-transition>
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:text-[#e3000f] hover:bg-slate-50">Home</a>
                <a href="{{ route('courses.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:text-[#e3000f] hover:bg-slate-50">Courses</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:text-[#e3000f] hover:bg-slate-50">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:text-[#e3000f] hover:bg-slate-50">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600">Log In</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-[#e3000f]">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl flex items-center gap-3">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-[#e3000f] rounded flex items-center justify-center text-white font-black text-sm">A</div>
                        <span class="text-white font-extrabold text-xl tracking-tight">THE ACE <span class="text-[#e3000f]">INDIA</span></span>
                    </div>
                    <p class="max-w-sm mb-6">Empowering students through quality education and expert-led recorded courses. Learn at your own pace with The Ace India.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">Quick Links</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('courses.index') }}" class="hover:text-white transition-colors">Courses</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">Legal</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-12 pt-8 text-center text-xs">
                &copy; {{ date('Y') }} The Ace India. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
