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

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F37021',
                        navy: '#1B365D',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer components {
            .youtube-embed {
                @apply aspect-video w-full rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white bg-black;
            }
            .video-container {
                @apply relative w-full pt-[56.25%];
            }
            .video-container iframe {
                @apply absolute top-0 left-0 w-full h-full border-0;
            }
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; background-color: #F4F4F4; }
    </style>
</head>
<body class="text-slate-900 antialiased">
    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-100 sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-[72px]">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white font-extrabold text-xl shadow-lg shadow-orange-500/20">
                            A
                        </div>
                        <span class="text-xl font-black tracking-tight text-navy hidden sm:block uppercase">The Ace <span class="text-primary">India</span></span>
                    </a>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-sm font-bold text-slate-600 hover:text-primary transition-colors">Home</a>
                    <a href="{{ route('courses.index') }}" class="text-sm font-bold text-slate-600 hover:text-primary transition-colors">Courses</a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-600 hover:text-primary transition-colors">My Dashboard</a>
                        <div class="h-6 w-px bg-slate-100"></div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <div class="text-sm font-bold text-navy leading-none">{{ auth()->user()->name }}</div>
                                <div class="text-[10px] text-primary font-black uppercase tracking-widest mt-1">
                                    {{ auth()->user()->is_admin ? 'Admin' : (auth()->user()->is_trainer ? 'Trainer' : 'Student') }}
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="p-2 text-slate-300 hover:text-primary transition-colors">
                                    <i class="bi bi-box-arrow-right text-xl"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-primary transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-black hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest">Enroll Now</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-500 p-2">
                        <i class="bi bi-list text-3xl" x-show="!mobileMenuOpen"></i>
                        <i class="bi bi-x-lg text-2xl" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden bg-white border-b border-slate-100" x-show="mobileMenuOpen" x-cloak x-transition>
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="{{ url('/') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-slate-600 hover:text-primary hover:bg-slate-50">Home</a>
                <a href="{{ route('courses.index') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-slate-600 hover:text-primary hover:bg-slate-50">Courses</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-slate-600 hover:text-primary hover:bg-slate-50">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-base font-bold text-slate-600 hover:text-primary hover:bg-slate-50">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-base font-bold text-slate-600">Log In</a>
                    <a href="{{ route('register') }}" class="block px-4 py-3 rounded-xl text-base font-black text-primary">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 shadow-sm">
                    <i class="bi bi-check-circle-fill"></i>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-navy text-slate-400 py-16 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-9 h-9 bg-primary rounded flex items-center justify-center text-white font-black text-lg">A</div>
                        <span class="text-white font-black text-2xl tracking-tight uppercase">The Ace <span class="text-primary">India</span></span>
                    </div>
                    <p class="max-w-sm mb-8 leading-relaxed">Empowering students through quality education and expert-led recorded courses. Learn at your own pace with The Ace India.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-8 uppercase text-[10px] tracking-[0.2em]">Quick Links</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#" class="hover:text-primary transition-colors">About Us</a></li>
                        <li><a href="{{ route('courses.index') }}" class="hover:text-primary transition-colors">Browse Courses</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Help Center</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-8 uppercase text-[10px] tracking-[0.2em]">Legal</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#" class="hover:text-primary transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-primary transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-16 pt-8 text-center text-xs font-bold tracking-widest uppercase opacity-40">
                &copy; {{ date('Y') }} The Ace India. Premium LMS Experience.
            </div>
        </div>
    </footer>
</body>
</html>
