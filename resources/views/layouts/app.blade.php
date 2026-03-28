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
                        accent: '#FEF1EA',
                        border: '#F4F4F4',
                        muted: '#333333',
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
            .nav-link {
                @apply flex items-center gap-[14px] px-[14px] py-[10px] rounded-[8px] mb-[4px] text-[14px] transition-all duration-200;
            }
            .nav-link-active {
                @apply bg-accent text-primary font-[700];
            }
            .nav-link-inactive {
                @apply text-muted font-[500] hover:bg-border hover:text-navy;
            }
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
        .sidebar-shadow { box-shadow: 2px 0 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="antialiased text-slate-900">
    <!-- If guest, show a simple top-nav (Welcome Page) -->
    @guest
        @if(View::hasSection('full_page'))
            @yield('content')
        @else
            <nav class="bg-white border-b border-border sticky top-0 z-50 shadow-sm">
                <div class="max-w-7xl mx-auto px-6 flex justify-between h-[72px] items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-[12px]">
                        <div class="w-[36px] h-[36px] bg-primary rounded-[8px] flex items-center justify-center text-white font-black text-lg shadow-lg shadow-orange-500/20 shrink-0">
                            <i class="bi bi-building-fill text-[18px]"></i>
                        </div>
                        <span class="text-[20px] font-[800] tracking-tight text-navy uppercase letter-spacing-[-0.5px]">The Ace India</span>
                    </a>
                    <div class="flex items-center gap-6">
                        <a href="{{ route('login') }}" class="text-[14px] font-[700] text-muted hover:text-primary transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-6 py-2.5 rounded-[8px] text-[14px] font-[800] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest">Enroll Now</a>
                    </div>
                </div>
            </nav>
            <main class="py-[32px]">
                <div class="max-w-7xl mx-auto px-6">
                    @yield('content')
                </div>
            </main>
        @endif
    @else
        <!-- AUTH SIDEBAR VIEW (EXACT MATCH) -->
        <div class="min-h-screen flex" x-data="{ sidebarOpen: window.innerWidth > 768 }">
            
            <!-- Backdrop for Mobile Overlay -->
            <div x-show="sidebarOpen && window.innerWidth < 768" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-navy/60 backdrop-blur-sm z-[1035] md:hidden"></div>

            <!-- Sidebar -->
            <aside 
                :class="{
                    'w-[260px] translate-x-0': sidebarOpen,
                    'w-[72px] translate-x-0': !sidebarOpen && window.innerWidth >= 768,
                    '-translate-x-full w-[260px]': !sidebarOpen && window.innerWidth < 768
                }"
                class="bg-white border-r border-border flex flex-col fixed inset-y-0 left-0 z-[1040] transition-all duration-300 sidebar-shadow"
            >
                <!-- Sidebar Header -->
                <div class="h-[72px] flex items-center px-[24px] gap-[12px] shrink-0 overflow-hidden">
                    <div class="w-[36px] h-[36px] bg-primary rounded-[8px] flex items-center justify-center text-white shrink-0">
                        <i class="bi bi-building-fill text-[18px]"></i>
                    </div>
                    <div x-show="sidebarOpen" x-transition class="font-[800] text-[20px] text-navy tracking-tight whitespace-nowrap overflow-hidden">
                        The Ace India
                    </div>
                </div>

                <!-- Profile Section -->
                <div x-show="sidebarOpen" x-transition class="p-[24px_20px] border-b border-border">
                    <div class="flex items-center gap-[14px] cursor-pointer">
                        <div class="w-[44px] h-[44px] rounded-full bg-border border-border shadow-sm overflow-hidden shrink-0 flex items-center justify-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[14px] font-[700] text-navy truncate">{{ auth()->user()->name }}</div>
                            <div class="text-[12px] text-muted truncate">{{ auth()->user()->email }}</div>
                        </div>
                        <i class="bi bi-chevron-down text-[12px] text-muted"></i>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto p-[16px_12px] space-y-1">
                    @php
                        $studentNav = [
                            ['label' => 'Dashboard',   'icon' => 'bi-house-door',     'route' => 'dashboard'],
                            ['label' => 'Courses',      'icon' => 'bi-play-circle',    'route' => 'enrollments.index'],
                            ['label' => 'Browse',       'icon' => 'bi-grid',           'route' => 'courses.index'],
                            ['label' => 'Live Classes', 'icon' => 'bi-camera-video',   'route' => 'live-classes.index'],
                            // ['label' => 'Resources',    'icon' => 'bi-file-earmark',   'route' => 'materials.index'],
                            ['label' => 'Billing',      'icon' => 'bi-credit-card',    'route' => 'fees.index'],
                            // ['label' => 'Profile',      'icon' => 'bi-person',         'route' => 'profile.edit'],
                            // ['label' => 'Register',     'icon' => 'bi-plus-circle',    'route' => 'admissions.create'],
                        ];
                    @endphp

                    @foreach($studentNav as $item)
                    @php $isActive = request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}" 
                       class="nav-link {{ $isActive ? 'nav-link-active' : 'nav-link-inactive' }}">
                        <div class="w-[18px] flex justify-center shrink-0">
                            <i class="bi {{ $item['icon'] }} text-[18px]"></i>
                        </div>
                        <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">{{ $item['label'] }}</span>
                    </a>
                    @endforeach
                </nav>

                <!-- Sidebar Footer -->
                <div x-show="sidebarOpen" x-transition class="p-[16px_12px] border-t border-border">
                    <!-- <a href="{{ route('profile.edit') }}" class="flex items-center gap-[14px] p-[10px_14px] text-muted hover:bg-border transition-all text-[14px] rounded-[8px]">
                        <i class="bi bi-person-circle text-[18px]"></i>
                        <span>Manage profile</span>
                    </a> -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-[14px] p-[10px_14px] text-muted hover:bg-red-50 hover:text-red-500 transition-all text-[14px] rounded-[8px]">
                            <i class="bi bi-box-arrow-right text-[18px]"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div 
                :class="{
                    'md:ml-[260px]': sidebarOpen,
                    'md:ml-[72px]': !sidebarOpen
                }"
                class="flex-1 flex flex-col transition-all duration-300 min-h-screen ml-0"
            >
                <!-- Header -->
                <header class="h-[64px] md:h-[72px] bg-white border-b border-border flex items-center justify-between px-4 md:px-8 sticky top-0 z-[1030]">
                    <div class="flex items-center gap-3 md:gap-5 flex-1">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-muted text-[24px] cursor-pointer flex p-1.5 hover:bg-border rounded-[8px] transition-all">
                            <i class="bi bi-list"></i>
                        </button>

                        <!-- Search Bar -->
                        <form action="{{ route('courses.index') }}" method="GET" class="hidden md:flex items-center relative w-[300px]">
                            <i class="bi bi-search absolute left-[12px] text-muted text-[14px]"></i>
                            <input type="text" name="search" placeholder="Quick search for anything.." 
                                   class="w-full pl-[36px] pr-[12px] py-[8px] bg-transparent border-none text-[14px] focus:outline-none font-[500]">
                        </form>
                    </div>

                    <div class="flex items-center gap-[20px]">
                        @php $notificationCount = 0; @endphp
                        {{-- <i class="bi bi-envelope text-[20px] text-muted cursor-pointer hover:text-primary transition-colors"></i> --}}
                        <div class="relative">
                            <i class="bi bi-bell text-[20px] text-muted cursor-pointer hover:text-primary transition-colors"></i>
                            @if($notificationCount > 0)
                                <span class="absolute -top-[4px] -right-[4px] bg-primary text-white text-[10px] font-[700] rounded-full w-[16px] h-[16px] flex items-center justify-center border-2 border-white">{{ $notificationCount }}</span>
                            @endif
                        </div>
                        <a href="{{ route('profile.edit') }}" class="w-[32px] h-[32px] rounded-full bg-border overflow-hidden cursor-pointer hover:ring-2 hover:ring-primary/20 transition-all">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" class="w-full h-full object-cover">
                        </a>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-4 md:p-8 flex-1 bg-[#F4F4F4]">
                    @if(session('success'))
                        <div class="mb-6 md:mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-[12px] flex items-center gap-3 text-[14px] font-[600]">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @endguest
</body>
</html>
