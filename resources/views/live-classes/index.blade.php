@extends('layouts.app')

@section('title', 'Live Interactive Classes - EduLMS')

@section('content')
<div class="space-y-12" x-data="{ activeTab: 'active' }">
    <!-- Header with Dynamic Aura -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-10 md:p-14 text-white shadow-2xl">
        <div class="absolute top-[-50px] right-[-50px] w-[300px] h-[300px] bg-primary/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-50px] left-[-50px] w-[200px] h-[200px] bg-orange-500/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="max-w-2xl">
                <span class="inline-block px-4 py-1 bg-white/10 backdrop-blur-md rounded-full text-[11px] font-[800] uppercase tracking-[0.2em] mb-4 border border-white/10">Interactive Learning</span>
                <h1 class="text-4xl md:text-5xl font-[900] tracking-tight mb-4">Live Interactive <span class="text-primary">Classes</span></h1>
                <p class="text-slate-300 text-lg font-[500] leading-relaxed">Join real-time, high-impact sessions with industry experts and your peers. Direct feedback, real-world insights, and collaborative learning.</p>
            </div>
            <div class="flex items-center gap-4 group cursor-default">
                <div class="w-[70px] h-[70px] rounded-[18px] bg-primary flex items-center justify-center shadow-lg shadow-orange-500/40 group-hover:scale-105 transition-transform">
                    <i class="bi bi-broadcast text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex items-center gap-2 p-1.5 bg-slate-100 rounded-[16px] w-fit mx-auto border border-slate-200/50 shadow-inner">
        <button @click="activeTab = 'active'" 
                :class="activeTab === 'active' ? 'bg-white text-navy shadow-md ring-1 ring-black/5' : 'text-slate-500 hover:text-navy'"
                class="px-8 py-3 rounded-[12px] text-[13px] font-[800] uppercase tracking-widest transition-all">
            Active Sessions
        </button>
        <button @click="activeTab = 'past'" 
                :class="activeTab === 'past' ? 'bg-white text-navy shadow-md ring-1 ring-black/5' : 'text-slate-500 hover:text-navy'"
                class="px-8 py-3 rounded-[12px] text-[13px] font-[800] uppercase tracking-widest transition-all">
            Past Sessions
        </button>
    </div>

    <!-- Active Sessions Tab -->
    <div x-show="activeTab === 'active'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="max-w-6xl mx-auto space-y-6">
        @forelse($activeClasses as $class)
            @php
                $startTime = \Carbon\Carbon::parse($class->start_time);
                $endTime = $startTime->copy()->addMinutes($class->duration);
                $now = \Carbon\Carbon::now();
                $isLive = $now->between($startTime, $endTime) || strtolower($class->status) === 'live';
                $isUpcoming = $now->lt($startTime) && strtolower($class->status) !== 'live';
                $isEnrolled = in_array($class->course_id, $enrolledCourseIds);
            @endphp
            
            <div class="group bg-white rounded-[24px] border border-border shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col md:flex-row items-stretch">
                <!-- Left: Thumbnail & Badges -->
                <div class="relative w-full md:w-[280px] h-[180px] md:h-auto overflow-hidden shrink-0">
                    <img src="{{ $class->course?->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                    
                    <!-- Status Overlays -->
                    <div class="absolute inset-0 bg-navy/20 group-hover:bg-transparent transition-colors duration-500 p-4">
                        @if($isLive && $isEnrolled)
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-rose-500 text-white rounded-full text-[10px] font-[900] uppercase tracking-widest shadow-lg animate-pulse">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                            </span>
                            Live Now
                        </div>
                        @elseif($isEnrolled)
                        <div class="inline-flex px-3 py-1 bg-primary text-white rounded-full text-[9px] font-[900] uppercase tracking-widest shadow-md">
                            Your Course
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Middle: Details -->
                <div class="flex-1 p-6 md:p-8 flex flex-col justify-center border-b md:border-b-0 md:border-r border-border/50">
                    <div class="text-[11px] font-[900] text-primary uppercase tracking-[0.3em] mb-2">
                        {{ $class->course?->title ?? 'Industry Insights' }}
                    </div>
                    <h3 class="text-2xl font-[800] text-navy leading-tight mb-4 group-hover:text-primary transition-colors">{{ $class->title }}</h3>
                    
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-2 text-[14px] font-[600] text-muted">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-primary group-hover:bg-primary/10 transition-colors">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <span>{{ $class->instructor_name }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-[14px] font-[600] text-muted">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-primary group-hover:bg-primary/10 transition-colors">
                                <i class="bi bi-clock"></i>
                            </div>
                            <span>{{ $class->duration }} Mins</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Schedule & Action -->
                <div class="w-full md:w-[280px] p-6 md:p-8 flex flex-col justify-center bg-slate-50/50 group-hover:bg-white transition-colors">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-[14px] bg-navy text-white flex items-center justify-center text-[14px] font-[900] flex-col leading-none shadow-md">
                            <span>{{ $startTime->format('d') }}</span>
                            <span class="text-[9px] uppercase opacity-60">{{ $startTime->format('M') }}</span>
                        </div>
                        <div>
                            <div class="text-navy font-[800] text-[15px]">{{ $startTime->format('g:i A') }}</div>
                            <div class="text-[11px] font-[600] text-muted uppercase tracking-widest italic leading-none mt-1">{{ $startTime->calendar() }}</div>
                        </div>
                    </div>

                    @if(!$isEnrolled)
                        <a href="{{ route('courses.show', $class->course_id) }}" class="w-full py-3.5 bg-primary text-white rounded-[16px] font-[800] text-[13px] uppercase tracking-widest shadow-xl shadow-orange-500/20 hover:bg-orange-600 hover:-translate-y-1 transition-all text-center">
                            Enroll to Join
                        </a>
                    @elseif($isLive)
                        <a href="{{ $class->zoom_link }}" target="_blank" class="w-full py-3.5 bg-navy text-white rounded-[16px] font-[800] text-[13px] uppercase tracking-widest shadow-xl shadow-navy/20 hover:bg-opacity-90 hover:-translate-y-1 transition-all text-center">
                            Join Now <i class="bi bi-camera-video ml-1"></i>
                        </a>
                    @else
                        <div class="w-full py-3.5 bg-white border border-navy/10 text-navy rounded-[16px] font-[800] text-[13px] uppercase tracking-widest text-center flex flex-col justify-center leading-none">
                            <span class="opacity-40 text-[10px] mb-1">Starts In</span>
                            <span>{{ $startTime->diffForHumans(null, true) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-slate-50 rounded-[32px] border-2 border-dashed border-slate-200 p-20 text-center">
                <i class="bi bi-camera-video-off text-4xl text-slate-300 mb-6 block"></i>
                <h3 class="text-2xl font-[900] text-navy mb-3">No Active Classes</h3>
                <p class="text-muted font-[500] max-w-sm mx-auto">Check back litearlly for upcoming interactive sessions.</p>
            </div>
        @endforelse
    </div>

    <!-- Past Sessions Tab -->
    <div x-show="activeTab === 'past'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="space-y-6 max-w-5xl mx-auto">
        @forelse($pastClasses as $class)
            <div class="bg-white p-6 rounded-[20px] border border-border flex flex-col md:flex-row items-center gap-8 group hover:border-primary/20 transition-all">
                <div class="w-full md:w-[200px] h-[120px] rounded-[14px] overflow-hidden shrink-0">
                    <img src="{{ $class->course?->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500">
                </div>
                <div class="flex-1">
                    <div class="text-[10px] font-[900] text-primary uppercase tracking-[0.2em] mb-1">Session Concluded</div>
                    <h4 class="text-xl font-[800] text-navy mb-2">{{ $class->title }}</h4>
                    <div class="flex flex-wrap gap-4 text-[13px] font-[600] text-muted">
                        <span class="flex items-center gap-1.5"><i class="bi bi-person-badge"></i> {{ $class->instructor_name }}</span>
                        <span class="flex items-center gap-1.5"><i class="bi bi-calendar-check"></i> {{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="shrink-0 pt-4 md:pt-0">
                    <span class="px-5 py-2.5 bg-slate-50 text-slate-400 rounded-full text-[12px] font-[800] uppercase tracking-widest border border-slate-100">Ended</span>
                </div>
            </div>
        @empty
            <div class="bg-slate-50 rounded-[24px] p-16 text-center border-2 border-dashed border-slate-200">
                <h3 class="text-xl font-[800] text-navy">No Past Sessions Yet</h3>
            </div>
        @endforelse
    </div>
</div>
@endsection
