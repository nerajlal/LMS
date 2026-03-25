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

    <!-- Tailwind & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased" x-data="{ sidebarOpen: true }">
    
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 bg-white border-r border-slate-200 z-50 transition-all duration-300 overflow-y-auto"
           :class="sidebarOpen ? 'w-64' : 'w-20'">
        
        <!-- Logo Area -->
        <div class="h-16 flex items-center px-6 border-b border-slate-100 bg-white sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-[#e3000f] rounded flex-shrink-0 flex items-center justify-center text-white font-black text-sm">A</div>
                <span class="font-extrabold text-slate-900 tracking-tight whitespace-nowrap" x-show="sidebarOpen">ADMIN <span class="text-[#e3000f]">PANEL</span></span>
            </div>
        </div>

        <nav class="p-4 space-y-1">
            @php
                $role = Auth::user()->is_admin ? 'admin' : 'trainer';
                $nav = $role === 'admin' ? [
                    ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'admin.dashboard'],
                    ['label' => 'Courses', 'icon' => 'bi-journal-bookmark', 'route' => 'admin.courses.index'],
                    ['label' => 'Instructors', 'icon' => 'bi-person-badge', 'route' => 'admin.trainers.index'],
                    ['label' => 'Students', 'icon' => 'bi-people', 'route' => 'admin.students.index'],
                    ['label' => 'Fees', 'icon' => 'bi-currency-dollar', 'route' => 'admin.fees.index'],
                ] : [
                    ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'trainer.dashboard'],
                    ['label' => 'My Courses', 'icon' => 'bi-journal-bookmark', 'route' => 'trainer.courses.index'],
                    ['label' => 'Live Classes', 'icon' => 'bi-camera-video', 'route' => 'trainer.live-classes.index'],
                ];
            @endphp

            @foreach($nav as $item)
                <a href="{{ route($item['route']) }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold transition-all {{ request()->routeIs($item['route'].'*') ? 'bg-[#e3000f]/5 text-[#e3000f]' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="bi {{ $item['icon'] }} text-xl"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ $item['label'] }}</span>
                </a>
            @endforeach

            <div class="pt-4 pb-2">
                <div class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2" x-show="sidebarOpen">Account</div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all">
                    <i class="bi bi-person-gear text-xl"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Settings</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-slate-500 hover:bg-red-50 hover:text-[#e3000f] transition-all">
                        <i class="bi bi-box-arrow-right text-xl"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap">Log Out</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Top Header -->
    <header class="fixed top-0 right-0 bg-white/80 backdrop-blur-md border-b border-slate-200 z-40 transition-all duration-300"
            :class="sidebarOpen ? 'left-64' : 'left-20'">
        <div class="h-16 px-6 flex items-center justify-between">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 -ml-2 text-slate-500 hover:text-[#e3000f]">
                <i class="bi bi-text-indent-left text-2xl" x-show="sidebarOpen"></i>
                <i class="bi bi-text-indent-right text-2xl" x-show="!sidebarOpen" x-cloak></i>
            </button>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-[#e3000f] font-bold uppercase tracking-wider mt-1">{{ $role }}</div>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-[#e3000f] font-bold border-2 border-white shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="transition-all duration-300 pt-24 pb-12 px-6"
          :class="sidebarOpen ? 'ml-64' : 'ml-20'">
        <div class="max-w-6xl mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl flex items-center gap-3 animate-slide-up">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <style>
        .animate-slide-up { animation: slideUp 0.3s ease-out forwards; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</body>
</html>
