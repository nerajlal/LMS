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
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        
        <!-- Sidebar -->
        <aside 
            :style="sidebarOpen ? 'width: 260px' : 'width: 72px'"
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
                    $role = auth()->user()->is_admin ? 'admin' : 'trainer';
                    $nav = $role === 'admin' ? [
                        ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'admin.dashboard'],
                        ['label' => 'Courses', 'icon' => 'bi-play-circle', 'route' => 'admin.courses.index'],
                        ['label' => 'Live Classes', 'icon' => 'bi-camera-video', 'route' => 'admin.live-classes.index'],
                        ['label' => 'Resources', 'icon' => 'bi-folder2-open', 'route' => 'admin.study-materials.index'],
                        ['label' => 'Trainers', 'icon' => 'bi-person-badge', 'route' => 'admin.trainers.index'],
                        ['label' => 'Students', 'icon' => 'bi-people', 'route' => 'admin.students.index'],
                        ['label' => 'Admissions', 'icon' => 'bi-clipboard-check', 'route' => 'admin.admissions.index'],
                        ['label' => 'Fees', 'icon' => 'bi-credit-card', 'route' => 'admin.fees.index'],
                    ] : [
                        ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'trainer.dashboard'],
                        ['label' => 'My Courses', 'icon' => 'bi-play-circle', 'route' => 'trainer.courses.index'],
                        ['label' => 'Live Classes', 'icon' => 'bi-camera-video', 'route' => 'trainer.live-classes.index'],
                        ['label' => 'Resources', 'icon' => 'bi-folder2-open', 'route' => 'trainer.study-materials.index'],
                    ];
                @endphp

                @foreach($nav as $item)
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
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-[14px] p-[10px_14px] text-muted hover:bg-border transition-all text-[14px] rounded-[8px]">
                    <i class="bi bi-person-circle text-[18px]"></i>
                    <span>Manage profile</span>
                </a>
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
            :style="sidebarOpen ? 'margin-left: 260px' : 'margin-left: 72px'"
            class="flex-1 flex flex-col transition-all duration-300 min-h-screen"
        >
            <!-- Header -->
            <header class="h-[72px] bg-white border-b border-border flex items-center justify-between px-[32px] sticky top-0 z-[1030]">
                <div class="flex items-center gap-[20px] flex-1">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-muted text-[24px] cursor-pointer flex p-1 hover:bg-border rounded-[8px] transition-all">
                        <i class="bi bi-list"></i>
                    </button>

                    <!-- Search Bar -->
                    <div class="hidden md:flex items-center relative w-[300px]">
                        <i class="bi bi-search absolute left-[12px] text-muted text-[14px]"></i>
                        <input type="text" placeholder="Quick search for anything.." 
                               class="w-full pl-[36px] pr-[12px] py-[8px] bg-transparent border-none text-[14px] focus:outline-none font-[500]">
                    </div>
                </div>

                <div class="flex items-center gap-[20px]">
                    <i class="bi bi-envelope text-[20px] text-muted cursor-pointer hover:text-primary transition-colors"></i>
                    <div class="relative">
                        <i class="bi bi-bell text-[20px] text-muted cursor-pointer hover:text-primary transition-colors"></i>
                        <span class="absolute -top-[4px] -right-[4px] bg-primary text-white text-[10px] font-[700] rounded-full w-[16px] h-[16px] flex items-center justify-center border-2 border-white">2</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <div class="text-[12px] font-black text-navy uppercase tracking-wider">{{ $role }}</div>
                        </div>
                        <div class="w-[32px] h-[32px] rounded-full bg-border overflow-hidden cursor-pointer">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-[32px] flex-1 bg-[#F4F4F4]">
                @if(session('success'))
                    <div class="mb-[32px] p-[16px] bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-[12px] flex items-center gap-[12px] text-[14px] font-[600]">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
