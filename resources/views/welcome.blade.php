@extends('layouts.app')

@section('title', 'Welcome to The Ace India - Best LMS Platform')

@section('content')
<div class="relative overflow-hidden pt-10 pb-20">
    <!-- Hero Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-50 text-[#F37021] text-xs font-bold uppercase tracking-widest rounded-full mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#F37021]"></span>
                </span>
                New Courses Available
            </div>
            <h1 class="text-5xl lg:text-7xl font-[800] text-slate-900 leading-[1.1] mb-8 tracking-tight">
                Unlock Your <span class="text-[#F37021]">Potential</span> with The Ace India
            </h1>
            <p class="text-lg text-slate-600 mb-10 max-w-lg leading-relaxed">
                Join thousands of students mastering new skills through our premium recorded courses and expert-led live interactive sessions.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-[#F37021] text-white font-bold rounded-xl hover:bg-[#E6631E] transition-all transform hover:-translate-y-1 shadow-xl shadow-red-500/30">
                    Explore Courses
                </a>
                <a href="#how-it-works" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
                    How it Works
                </a>
            </div>
            
            <div class="mt-12 flex items-center gap-6">
                <div class="flex -space-x-3">
                    <img class="w-10 h-10 rounded-full border-4 border-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150" alt="">
                    <img class="w-10 h-10 rounded-full border-4 border-white object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=150" alt="">
                    <img class="w-10 h-10 rounded-full border-4 border-white object-cover" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=150" alt="">
                    <div class="w-10 h-10 rounded-full border-4 border-white bg-slate-900 text-white text-[10px] flex items-center justify-center font-bold">+2k</div>
                </div>
                <div class="text-sm text-slate-500 font-medium">
                    Trusted by <span class="text-slate-900 font-bold">2,000+</span> ambitious students
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-red-100 rounded-full blur-3xl opacity-30"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blue-100 rounded-full blur-3xl opacity-30"></div>
            <div class="relative bg-white p-4 rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden group">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=1200" 
                     alt="Learning" 
                     class="rounded-3xl object-cover w-full h-[500px] transition-transform duration-700 group-hover:scale-105">
                <div class="absolute bottom-10 left-10 right-10 p-6 bg-white/90 backdrop-blur-md rounded-2xl border border-white/50 shadow-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#F37021] rounded-xl flex items-center justify-center text-white shadow-lg shadow-orange-500/20">
                            <i class="bi bi-play-fill text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-[#F37021] uppercase tracking-widest">Featured Course</div>
                            <div class="text-lg font-extrabold text-slate-900 leading-tight">Mastering Modern Web Design 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="mt-32 grid grid-cols-2 md:grid-cols-4 gap-8">
        @foreach([
            ['label' => 'Total Courses', 'value' => '50+', 'icon' => 'bi-journal-check', 'color' => 'bg-blue-50 text-blue-600'],
            ['label' => 'Active Learners', 'value' => '2,500', 'icon' => 'bi-people', 'color' => 'bg-red-50 text-[#F37021]'],
            ['label' => 'Expert Mentors', 'value' => '15+', 'icon' => 'bi-person-badge', 'color' => 'bg-amber-50 text-amber-600'],
            ['label' => 'Success Rate', 'value' => '98%', 'icon' => 'bi-star-fill', 'color' => 'bg-emerald-50 text-emerald-600'],
        ] as $stat)
        <div class="text-center p-8 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 {{ $stat['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl">
                <i class="{{ $stat['icon'] }}"></i>
            </div>
            <div class="text-3xl font-black text-slate-900 mb-1">{{ $stat['value'] }}</div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Featured Courses Preview -->
    <div class="mt-40">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-sm font-bold text-[#F37021] uppercase tracking-[0.2em] mb-3">Popular Programs</h2>
                <h3 class="text-4xl font-extrabold text-slate-900 tracking-tight">Our Most <span class="text-[#F37021]">Favorite</span> Courses</h3>
            </div>
            <a href="{{ route('courses.index') }}" class="hidden sm:flex items-center gap-2 text-slate-600 font-bold hover:text-[#F37021] transition-colors">
                View All Courses <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Placeholder course cards --}}
            @for($i = 1; $i <= 3; $i++)
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all overflow-hidden flex flex-col">
                <div class="relative h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&q=80&w=800" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center text-white">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-bold uppercase tracking-widest">Technology</span>
                        <div class="flex items-center gap-1 text-amber-400">
                            <i class="bi bi-star-fill text-xs"></i>
                            <span class="text-white text-xs font-bold">4.9</span>
                        </div>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-[#F37021] transition-colors line-clamp-2">Complete Fullstack Web Development Bootcamp</h4>
                    <div class="text-sm text-slate-500 mb-6 line-clamp-2 leading-relaxed">Master modern technologies from frontend to backend with hands-on projects and real-world examples.</div>
                    <div class="mt-auto flex items-center justify-between pt-6 border-t border-slate-50">
                        <div class="flex items-center gap-2">
                            <img class="w-8 h-8 rounded-full object-cover " src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=150" alt="">
                            <span class="text-xs font-bold text-slate-700">Neraj Lal</span>
                        </div>
                        <div class="text-xl font-black text-[#F37021]">₹4,999</div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
