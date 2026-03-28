<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

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
    <div class="min-h-screen flex relative" x-data="{ sidebarOpen: window.innerWidth > 1024 }">
        
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-navy/60 backdrop-blur-sm z-[1045] lg:hidden"
             x-cloak>
        </div>

        <!-- Sidebar -->
        <aside 
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="bg-white border-r border-border flex flex-col fixed inset-y-0 left-0 z-[1050] transition-all duration-300 sidebar-shadow w-[280px] lg:w-[260px]"
            x-cloak
            @resize.window="if (window.innerWidth > 1024) sidebarOpen = true"
        >
            <!-- Sidebar Header -->
            <div class="h-[72px] flex items-center px-[24px] gap-[12px] shrink-0 overflow-hidden border-b border-border/50">
                <div class="w-[36px] h-[36px] bg-primary rounded-[10px] flex items-center justify-center text-white shrink-0 shadow-lg shadow-orange-500/20">
                    <i class="bi bi-building-fill text-[18px]"></i>
                </div>
                <div class="font-[900] text-[18px] text-navy tracking-tight whitespace-nowrap">
                    The Ace <span class="text-primary">India</span>
                </div>
                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-navy">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <!-- Profile Section -->
            <div class="p-[20px] border-b border-border/50 bg-slate-50/50">
                <div class="flex items-center gap-[12px]">
                    <div class="w-[40px] h-[40px] rounded-[10px] bg-white border border-border shadow-sm overflow-hidden shrink-0 flex items-center justify-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1B365D&color=fff" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13px] font-[800] text-navy truncate leading-tight">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-slate-400 font-[600] uppercase tracking-wider truncate mt-0.5">{{ auth()->user()->is_admin ? 'Admin' : 'Trainer' }} Profile</div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-[16px_12px] space-y-1 custom-scrollbar">
                @php
                    $role = auth()->user()->is_admin ? 'admin' : 'trainer';
                    $nav = $role === 'admin' ? [
                        ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'admin.dashboard'],
                        ['label' => 'Courses', 'icon' => 'bi-play-circle', 'route' => 'admin.courses.index'],
                        ['label' => 'Live Classes', 'icon' => 'bi-camera-video', 'route' => 'admin.live-classes.index'],
                        // ['label' => 'Resources', 'icon' => 'bi-folder2-open', 'route' => 'admin.study-materials.index'],
                        ['label' => 'Trainers', 'icon' => 'bi-person-badge', 'route' => 'admin.trainers.index'],
                        ['label' => 'Students', 'icon' => 'bi-people', 'route' => 'admin.students.index'],
                        // ['label' => 'Admissions', 'icon' => 'bi-clipboard-check', 'route' => 'admin.admissions.index'],
                        ['label' => 'Issue Certificate', 'icon' => 'bi-award', 'route' => 'admin.admissions.index', 'params' => ['tab' => 'completed']],
                        ['label' => 'Fees', 'icon' => 'bi-credit-card', 'route' => 'admin.fees.index'],
                    ] : [
                        ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'trainer.dashboard'],
                        ['label' => 'My Courses', 'icon' => 'bi-play-circle', 'route' => 'trainer.courses.index'],
                        ['label' => 'Live Classes', 'icon' => 'bi-camera-video', 'route' => 'trainer.live-classes.index'],
                        ['label' => 'Resources', 'icon' => 'bi-folder2-open', 'route' => 'trainer.study-materials.index'],
                    ];
                @endphp

                @foreach($nav as $item)
                @php 
                    $isActive = request()->routeIs($item['route']);
                    $params = $item['params'] ?? [];
                @endphp
                <a href="{{ route($item['route'], $params) }}" 
                   class="nav-link {{ $isActive ? 'bg-primary/10 text-primary font-[800]' : 'text-slate-500 font-[600] hover:bg-slate-50 hover:text-navy' }} flex items-center gap-[12px] px-[14px] py-[10px] rounded-[10px] text-[13px] transition-all">
                    <div class="w-[20px] flex justify-center shrink-0">
                        <i class="bi {{ $item['icon'] }} text-[18px]"></i>
                    </div>
                    <span class="whitespace-nowrap">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-[16px_12px] border-t border-border/50 bg-slate-50/30">
{{-- <a href="{{ route('profile.edit') }}" class="flex items-center gap-[12px] p-[10px_14px] text-slate-500 font-[600] hover:bg-white hover:text-navy hover:shadow-sm transition-all text-[13px] rounded-[10px] mb-1">
                    <i class="bi bi-person-circle text-[18px]"></i>
                    <span>Manage profile</span>
                </a> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-[12px] p-[10px_14px] text-slate-400 font-[600] hover:bg-red-50 hover:text-red-500 transition-all text-[13px] rounded-[10px]">
                        <i class="bi bi-box-arrow-right text-[18px]"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div 
            class="flex-1 flex flex-col transition-all duration-300 min-h-screen w-full lg:ml-[260px]"
        >
            <!-- Header -->
            <header class="h-[72px] bg-white border-b border-border flex items-center justify-between px-4 md:px-8 sticky top-0 z-[1030] shadow-sm">
                <div class="flex items-center gap-[16px] flex-1">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-navy text-[24px] cursor-pointer flex p-2 hover:bg-slate-50 rounded-[10px] transition-all">
                        <i class="bi bi-list"></i>
                    </button>

                    <!-- Search Bar -->
                    <form action="{{ auth()->user()->is_admin ? route('admin.courses.index') : route('trainer.courses.index') }}" method="GET" class="hidden md:flex items-center relative w-[300px]">
                        <i class="bi bi-search absolute left-[12px] text-slate-400 text-[14px]"></i>
                        <input type="text" name="search" placeholder="Quick search for anything.." 
                               class="w-full pl-[36px] pr-[12px] py-[8px] bg-transparent border-none text-[14px] focus:outline-none font-[600] text-navy">
                    </form>
                </div>

                <div class="flex items-center gap-[20px]">
                    @php $notificationCount = 0; @endphp
                    <div class="relative">
                        <i class="bi bi-bell text-[20px] text-slate-400 cursor-pointer hover:text-primary transition-colors"></i>
                        @if($notificationCount > 0)
                            <span class="absolute -top-[4px] -right-[4px] bg-primary text-white text-[10px] font-[700] rounded-full w-[16px] h-[16px] flex items-center justify-center border-2 border-white">{{ $notificationCount }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <div class="text-[10px] font-black text-primary uppercase tracking-wider leading-none">{{ auth()->user()->is_admin ? 'Administrator' : 'Instructor' }}</div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="w-[36px] h-[36px] rounded-[10px] border border-border bg-slate-50 overflow-hidden cursor-pointer shadow-sm hover:ring-2 hover:ring-primary/20 transition-all block">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1B365D&color=fff" class="w-full h-full object-cover">
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-4 md:p-8 flex-1 bg-slate-50">
                @if(session('success'))
                    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-[12px] flex items-center gap-3 text-[14px] font-[700] shadow-sm">
                        <i class="bi bi-check-circle-fill text-emerald-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
