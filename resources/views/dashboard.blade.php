@extends('layouts.app')

@section('title', 'Student Workspace - The Ace India')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Welcome Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-7 text-white shadow-2xl">
        <div class="absolute top-[-30px] right-[-30px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px] animate-pulse"></div>
        <div class="absolute bottom-[-50px] left-[-50px] w-[150px] h-[150px] bg-sky-500/10 rounded-full blur-[60px]"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-[16px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-xl shadow-2xl group overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=F37021&color=fff&bold=true" 
                         class="w-full h-full object-cover opacity-90 group-hover:scale-110 transition-transform duration-700">
                </div>
                <div>
                    <h1 class="text-2xl font-[900] tracking-tight leading-tight">Welcome back, <span class="text-primary">{{ explode(' ', auth()->user()->name)[0] }}!</span></h1>
                    <p class="text-slate-400 text-[12px] font-[600] uppercase tracking-[0.2em] mt-1 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        Identity Verified
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-white/5 border border-white/10 p-4 rounded-[16px] backdrop-blur-md">
                <div class="text-right">
                    <div class="text-[11px] font-[800] text-primary uppercase tracking-widest mb-1">Learning Streak</div>
                    <div class="text-xl font-[900] text-white">12 Days <i class="bi bi-fire text-orange-500 ml-1"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $statCards = [
                ['label' => 'Courses Active', 'value' => $stats['enrolled'], 'icon' => 'bi-play-fill', 'gradient' => 'from-navy to-[#254d85]', 'iconColor' => 'text-primary'],
                ['label' => 'Certifications', 'value' => $stats['certifications'], 'icon' => 'bi-award-fill', 'gradient' => 'from-white to-slate-50', 'iconColor' => 'text-navy'],
                ['label' => 'Completed', 'value' => $stats['completed'], 'icon' => 'bi-check-circle-fill', 'gradient' => 'from-white to-slate-50', 'iconColor' => 'text-emerald-500'],
                ['label' => 'Watchlist', 'value' => $stats['wishlist'], 'icon' => 'bi-bookmark-heart-fill', 'gradient' => 'from-white to-slate-50', 'iconColor' => 'text-rose-500'],
            ];
        @endphp

        @foreach($statCards as $index => $card)
        <div class="relative group bg-gradient-to-br {{ $card['gradient'] }} p-4 rounded-[16px] border border-border shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden {{ $index === 0 ? 'text-white border-navy' : '' }}">
            @if($index === 0)
                <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="bi {{ $card['icon'] }} text-[60px]"></i>
                </div>
            @endif
            
            <div class="relative z-10 flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-[12px] {{ $index === 0 ? 'bg-white/10' : 'bg-slate-100' }} flex items-center justify-center {{ $card['iconColor'] }} shadow-inner shrink-0">
                    <i class="bi {{ $card['icon'] }} text-lg"></i>
                </div>
                <div class="min-w-0 pr-2">
                    <div class="text-xl font-[900] {{ $index === 0 ? 'text-white' : 'text-navy' }} leading-none mb-1">{{ sprintf('%02d', $card['value']) }}</div>
                    <div class="text-[10px] font-[800] {{ $index === 0 ? 'text-slate-300' : 'text-muted' }} uppercase tracking-widest leading-tight line-clamp-1 truncate">{{ $card['label'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Main Area: Learning Progress -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-[16px] border border-border shadow-sm overflow-hidden min-h-[400px] flex flex-col">
                <div class="px-6 py-4 border-b border-border flex justify-between items-center bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-[8px] bg-primary/10 flex items-center justify-center text-primary">
                            <i class="bi bi-collection-play-fill text-sm"></i>
                        </div>
                        <h2 class="text-[16px] font-[900] text-navy tracking-tight">Active Learning Tracks</h2>
                    </div>
                    <a href="{{ route('courses.index') }}" class="px-3 py-1.5 bg-white border border-border text-navy text-[11px] font-[800] uppercase tracking-widest rounded-[8px] hover:bg-navy hover:text-white transition-all shadow-sm">View All</a>
                </div>
                
                <div class="p-4 flex-1">
                    @forelse($enrolledCourses as $course)
                    <div class="group bg-slate-50/30 hover:bg-white rounded-[14px] border border-transparent hover:border-border hover:shadow-xl p-3 mb-3 last:mb-0 transition-all duration-500 flex flex-col md:flex-row items-center gap-5">
                        <div class="relative w-full md:w-[120px] h-[75px] rounded-[12px] overflow-hidden shrink-0 shadow-lg">
                            <img src="{{ $course['thumbnail'] ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=300' }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-navy/20 group-hover:bg-transparent transition-colors"></div>
                        </div>
Prefix:                         <div class="flex-1 w-full min-w-0">
                            <div class="flex justify-between items-start mb-1.5">
                                <h3 class="text-[14px] font-[800] text-navy truncate group-hover:text-primary transition-colors pr-4">{{ $course['title'] }}</h3>
                                <div class="text-[11px] font-[900] text-primary whitespace-nowrap">{{ $course['progress'] }}%</div>
                            </div>
                            
                            <div class="relative h-1.5 bg-slate-200 rounded-full overflow-hidden mb-3 shadow-inner">
                                <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-primary to-orange-400 rounded-full transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(243,112,33,0.3)]" style="width: {{ $course['progress'] }}%"></div>
                            </div>
Prefix:                             <div class="flex items-center gap-4 text-[10px] font-[700] text-muted uppercase tracking-widest">
                                <span class="flex items-center gap-1.5"><i class="bi bi-person text-primary"></i> {{ $course['instructor'] }}</span>
                                <span class="flex items-center gap-1.5"><i class="bi bi-stack text-primary"></i> {{ $course['lessons_count'] }} Lessons</span>
                            </div>
                        </div>
Prefix:                         <div class="shrink-0 w-full md:w-auto">
                            <a href="{{ route('courses.show', $course['id']) }}" 
                               class="w-full md:w-auto block px-5 py-2.5 bg-navy text-white rounded-[10px] text-[11px] font-[900] uppercase tracking-widest shadow-xl shadow-navy/20 hover:bg-primary hover:-translate-y-0.5 transition-all text-center">
                                Resume <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-300 mb-4 animate-bounce">
                            <i class="bi bi-inbox text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-[800] text-navy mb-2">Your bookshelf is empty</h3>
                        <p class="text-muted text-[14px] max-w-xs mx-auto mb-8">Start your journey today by exploring our hand-picked interactive courses.</p>
                        <a href="{{ route('courses.index') }}" class="px-8 py-3.5 bg-primary text-white rounded-[14px] font-[800] uppercase tracking-widest text-[13px] shadow-xl shadow-orange-500/20 hover:scale-105 transition-all">Browse Courses</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Area: Widgets -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Upcoming Live Widget -->
            <div class="bg-navy rounded-[16px] p-5 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute top-[-20px] right-[-20px] w-28 h-28 bg-primary/20 rounded-full blur-[35px] group-hover:scale-150 transition-transform duration-1000"></div>
                
                <h3 class="text-[12px] font-[900] uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_8px_#4ade80]"></span>
                    Next Live Class
                </h3>

                @php $nextClass = $upcomingClasses->first(); @endphp
                @if($nextClass)
                    <div class="space-y-4 relative z-10">
                        <div class="p-3.5 bg-white/5 border border-white/10 rounded-[14px] backdrop-blur-md">
                            <p class="text-[11px] text-slate-400 font-[600] mb-1 italic">Starts {{ \Carbon\Carbon::parse($nextClass['time'])->diffForHumans() }}</p>
                            <h4 class="text-sm font-[800] mb-2.5 leading-tight">{{ $nextClass['title'] }}</h4>
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-primary/20 flex items-center justify-center text-primary text-xs">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <span class="text-[12px] font-[700]">{{ $nextClass['host'] }}</span>
                            </div>
                        </div>
                        <a href="{{ route('live-classes.index') }}" class="w-full py-2.5 bg-white text-navy rounded-[12px] font-[900] text-[11px] uppercase tracking-widest text-center block hover:bg-primary hover:text-white transition-all shadow-lg">Set Reminder</a>
                    </div>
                @else
                    <p class="text-slate-400 text-[13px] italic">No interactive sessions scheduled for now. Check back soon!</p>
                @endif
            </div>

            <!-- Top Mentors Widget -->
            <div class="bg-white rounded-[16px] border border-border shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-border bg-slate-50/50">
                    <h3 class="text-[12px] font-[900] text-navy uppercase tracking-widest">Global Top Mentors</h3>
                </div>
                <div class="p-2 space-y-0.5">
                    @forelse($topInstructors as $index => $instructor)
                    <a href="{{ route('courses.index', ['instructor' => $instructor['name']]) }}" class="flex items-center gap-3 p-2 rounded-[12px] hover:bg-slate-50 transition-colors group cursor-pointer border border-transparent hover:border-border">
                        <div class="relative">
                            <div class="w-9 h-9 rounded-full border-2 border-primary/20 group-hover:border-primary transition-colors p-[2px]">
                                <img src="{{ $instructor['avatar'] }}" class="w-full h-full rounded-full object-cover">
                            </div>
                            @if($index < 3)
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-white shadow-sm rounded-full flex items-center justify-center">
                                <i class="bi bi-award-fill text-[10px] text-warning text-yellow-500"></i>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-[13px] font-[800] text-navy group-hover:text-primary transition-colors">{{ $instructor['name'] }}</h4>
                            <p class="text-[10px] font-[600] text-muted uppercase tracking-widest">{{ $instructor['courses'] }} Blueprints</p>
                        </div>
                        <div class="text-primary opacity-0 group-hover:opacity-100 transition-all -translate-x-1 group-hover:translate-x-0">
                            <i class="bi bi-chevron-right text-base"></i>
                        </div>
                    </a>
                    @empty
                    <div class="p-6 text-center text-slate-400 italic text-[13px]">Establishing mentor network...</div>
                    @endforelse
                </div>
                <div class="p-3 border-t border-slate-50">
                    <a href="{{ route('courses.index') }}" class="w-full block py-2.5 text-center text-[11px] font-[800] text-navy uppercase tracking-widest hover:text-primary transition-colors">Explore Curriculum <i class="bi bi-graph-up ml-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
