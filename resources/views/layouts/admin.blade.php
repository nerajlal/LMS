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
            .nav-link-active {
                @apply bg-accent text-primary font-bold shadow-sm;
            }
            .nav-link-inactive {
                @apply text-slate-600 hover:bg-slate-50 hover:text-navy;
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
<body class="antialiased text-slate-900">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        
        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-50 transition-all duration-300 shadow-xl shadow-slate-200/50"
        >
            <!-- Sidebar Header -->
            <div class="h-[72px] flex items-center px-6 gap-3 shrink-0">
                <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-orange-500/20 shrink-0">
                    <i class="bi bi-building-fill text-lg"></i>
                </div>
                <div x-show="sidebarOpen" x-transition class="font-black text-xl text-navy tracking-tight overflow-hidden whitespace-nowrap">
                    The Ace India
                </div>
            </div>

            <!-- Profile Section (Top of Sidebar) -->
            <div x-show="sidebarOpen" x-transition class="px-5 py-6 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-slate-100 border-2 border-white shadow-sm overflow-hidden shrink-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" class="w-full h-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-navy truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[11px] text-slate-400 font-medium truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                @php
                    $role = auth()->user()->is_admin ? 'admin' : 'trainer';
                    $nav = $role === 'admin' ? [
                        ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'admin.dashboard'],
                        ['label' => 'Courses', 'icon' => 'bi-journal-bookmark', 'route' => 'admin.courses.index'],
                        ['label' => 'Students', 'icon' => 'bi-people', 'route' => 'admin.students.index'],
                        ['label' => 'Admissions', 'icon' => 'bi-clipboard-check', 'route' => 'admin.admissions.index'],
                        ['label' => 'Fees & Payments', 'icon' => 'bi-credit-card', 'route' => 'admin.fees.index'],
                        ['label' => 'Trainers', 'icon' => 'bi-person-badge', 'route' => 'admin.trainers.index'],
                    ] : [
                        ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'trainer.dashboard'],
                        ['label' => 'My Courses', 'icon' => 'bi-journal-bookmark', 'route' => 'trainer.courses.index'],
                        ['label' => 'Live Classes', 'icon' => 'bi-camera-video', 'route' => 'trainer.live-classes.index'],
                    ];
                @endphp

                @foreach($nav as $item)
                <a href="{{ route($item['route']) }}" 
                   class="flex items-center p-3 rounded-xl transition-all group whitespace-nowrap {{ request()->routeIs($item['route']) ? 'nav-link-active' : 'nav-link-inactive' }}">
                    <div class="w-8 flex justify-center shrink-0">
                        <i class="bi {{ $item['icon'] }} text-lg"></i>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-semibold">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 bg-slate-50/50">
                <a href="{{ route('profile.edit') }}" class="flex items-center p-3 rounded-xl text-slate-600 hover:bg-white hover:text-navy transition-all mb-1">
                    <div class="w-8 flex justify-center shrink-0"><i class="bi bi-person-circle"></i></div>
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-semibold">Profile Settings</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all">
                        <div class="w-8 flex justify-center shrink-0"><i class="bi bi-box-arrow-right"></i></div>
                        <span x-show="sidebarOpen" x-transition class="ml-3 text-sm font-semibold">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div 
            :class="sidebarOpen ? 'ml-64' : 'ml-20'"
            class="flex-1 flex flex-col transition-all duration-300"
        >
            <!-- Header -->
            <header class="h-[72px] bg-white border-b border-slate-100 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
                <div class="flex items-center gap-6 flex-1">
                    <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-400 transition-all">
                        <i class="bi bi-list text-2xl"></i>
                    </button>

                    <!-- Search Bar -->
                    <div class="hidden md:flex items-center relative w-full max-w-sm">
                        <i class="bi bi-search absolute left-4 text-slate-400"></i>
                        <input type="text" placeholder="Quick search for anything.." 
                               class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-400 transition-all relative">
                        <i class="bi bi-envelope text-xl"></i>
                    </button>
                    <button class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-400 transition-all relative">
                        <i class="bi bi-bell text-xl"></i>
                        <span class="absolute top-2 right-2 w-4 h-4 bg-primary text-white text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-white shadow-sm">2</span>
                    </button>
                    <div class="h-8 w-px bg-slate-100 mx-2"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <div class="text-xs font-bold text-navy uppercase tracking-wider">{{ $role }}</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-primary font-bold border-2 border-white shadow-sm uppercase">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-8">
                @if(session('success'))
                    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 shadow-sm">
                        <i class="bi bi-check-circle-fill"></i>
                        <span class="font-bold text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
