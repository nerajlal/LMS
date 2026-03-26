@extends('layouts.app')

@section('title', 'Live Interactive Classes - EduLMS')

@section('content')
<div class="space-y-12">
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

    <!-- Live Classes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        @forelse($classes as $class)
            @php
                $startTime = \Carbon\Carbon::parse($class->start_time);
                $endTime = $startTime->copy()->addMinutes($class->duration);
                $now = \Carbon\Carbon::now();
                $isLive = $now->between($startTime, $endTime) || strtolower($class->status) === 'live';
                $isUpcoming = $now->lt($startTime) && strtolower($class->status) !== 'live';
                $isEnrolled = in_array($class->course_id, $enrolledCourseIds);
            @endphp
            
            <div class="group bg-white rounded-[24px] border border-border shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col">
                <!-- Top Section: Visual & Overlay -->
                <div class="relative h-[220px] overflow-hidden">
                    <img src="{{ $class->course?->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                    
                    <!-- Glassmorphism Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/90 via-navy/40 to-transparent flex flex-col justify-end p-8">
                        @if($isLive && $isEnrolled)
                        <div class="absolute top-6 left-6 flex items-center gap-2 px-3 py-1.5 bg-rose-500 text-white rounded-full text-[10px] font-[900] uppercase tracking-widest shadow-lg animate-pulse">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                            </span>
                            Active Now
                        </div>
                        @endif

                        <div class="text-[11px] font-[900] text-primary uppercase tracking-[0.3em] mb-2 drop-shadow-md">
                            {{ $class->course?->title ?? 'Industry Insights' }}
                        </div>
                        <h3 class="text-2xl font-[800] text-white leading-tight drop-shadow-lg">{{ $class->title }}</h3>
                    </div>
                </div>

                <!-- Bottom Section: Details -->
                <div class="p-8 flex-1 flex flex-col">
                    <div class="grid grid-cols-2 gap-6 mb-8 pt-2">
                        <!-- Instructor Card -->
                        <div class="bg-slate-50 p-4 rounded-[16px] border border-slate-100 group-hover:bg-white group-hover:border-primary/20 transition-all">
                            <div class="text-[10px] font-[800] text-muted uppercase tracking-widest mb-1 items-center flex gap-1.5">
                                <i class="bi bi-person-badge text-primary"></i> Instructor
                            </div>
                            <div class="text-navy font-[800] text-[15px] truncate">{{ $class->instructor_name }}</div>
                        </div>

                        <!-- Date/Time Card -->
                        <div class="bg-slate-50 p-4 rounded-[16px] border border-slate-100 group-hover:bg-white group-hover:border-primary/20 transition-all">
                            <div class="text-[10px] font-[800] text-muted uppercase tracking-widest mb-1 items-center flex gap-1.5">
                                <i class="bi bi-clock text-primary"></i> Duration
                            </div>
                            <div class="text-navy font-[800] text-[15px]">{{ $class->duration }} Mins</div>
                        </div>
                    </div>

                    <!-- Full Schedule View -->
                    <div class="flex items-center gap-4 px-5 py-4 bg-navy/[0.03] rounded-[16px] border border-dashed border-navy/10 mb-8">
                        <div class="w-10 h-10 rounded-[10px] bg-navy text-white flex items-center justify-center text-[12px] font-[900] flex-col leading-none shadow-md">
                            <span>{{ $startTime->format('d') }}</span>
                            <span class="text-[8px] uppercase opacity-60">{{ $startTime->format('M') }}</span>
                        </div>
                        <div>
                            <div class="text-navy font-[800] text-[14px]">{{ $startTime->format('g:i A') }} • Local Time</div>
                            <div class="text-[11px] font-[600] text-muted uppercase tracking-widest italic">{{ $startTime->calendar() }}</div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-auto">
                        @if(!$isEnrolled)
                            <a href="{{ route('courses.show', $class->course_id) }}" class="w-full flex items-center justify-center gap-3 py-4 bg-primary text-white rounded-[16px] font-[800] uppercase tracking-widest shadow-xl shadow-orange-500/20 hover:bg-orange-600 hover:-translate-y-1 transition-all">
                                Enroll to Join <i class="bi bi-arrow-right-short text-xl"></i>
                            </a>
                        @elseif($isLive)
                            <a href="{{ $class->zoom_link }}" target="_blank" class="w-full flex items-center justify-center gap-3 py-4 bg-navy text-white rounded-[16px] font-[800] uppercase tracking-widest shadow-xl shadow-navy/20 hover:bg-navy/90 hover:-translate-y-1 transition-all">
                                Join Session Now <i class="bi bi-camera-video text-lg ml-2"></i>
                            </a>
                        @elseif($isUpcoming)
                            <button class="w-full py-4 bg-slate-100 text-navy rounded-[16px] font-[800] uppercase tracking-widest opacity-90 cursor-default flex flex-col items-center justify-center leading-none border border-navy/10">
                                <span class="text-[14px]">Upcoming Session</span>
                                <span class="text-[9px] mt-1 opacity-60 text-primary">Starts {{ $startTime->diffForHumans() }}</span>
                            </button>
                        @else
                            <button class="w-full py-4 bg-slate-100 text-slate-400 rounded-[16px] font-[800] uppercase tracking-widest cursor-not-allowed">
                                Session Ended
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 bg-slate-50 rounded-[32px] border-2 border-dashed border-slate-200 p-20 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-8 text-primary shadow-sm">
                    <i class="bi bi-camera-video-off text-3xl"></i>
                </div>
                <h3 class="text-2xl font-[900] text-navy mb-3">No Classes Currently Scheduled</h3>
                <p class="text-muted text-lg font-[500] max-w-sm mx-auto">Instructors haven't posted any sessions for today. Check back soon for new opportunities!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
