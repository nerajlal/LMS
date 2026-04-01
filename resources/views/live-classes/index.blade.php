@extends('layouts.app')

@section('title', 'Live Interactive Classes - EduLMS')

@section('content')
<div class="space-y-8" x-data="{ activeTab: '{{ count($activeClasses) > 0 ? 'active' : (count($upcomingClasses) > 0 ? 'upcoming' : 'active') }}' }">
    <!-- Compact Cinematic Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[150px] h-[150px] bg-primary/20 rounded-full blur-[60px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[12px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-broadcast text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-[900] tracking-tight">Live <span class="text-primary">Sessions</span></h1>
                    <p class="text-slate-400 text-[12px] font-[600] uppercase tracking-widest mt-0.5">Interactive Expert-Led Learning</p>
                </div>
            </div>

            <!-- Inline Stats -->
            <div class="flex items-center gap-8 md:border-l border-white/10 md:pl-8">
                <div class="flex flex-col">
                    <span class="text-[10px] font-[800] text-emerald-400 uppercase tracking-widest flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        Active
                    </span>
                    <span class="text-xl font-[900] text-white">{{ count($activeClasses) }}</span>
                </div>
                <div class="flex flex-col border-l border-white/10 pl-8">
                    <span class="text-[10px] font-[800] text-white/40 uppercase tracking-widest">Upcoming</span>
                    <span class="text-xl font-[900] text-white">{{ count($upcomingClasses) }}</span>
                </div>
                <div class="flex flex-col border-l border-white/10 pl-8">
                    <span class="text-[10px] font-[800] text-white/40 uppercase tracking-widest">Completed</span>
                    <span class="text-xl font-[900] text-white/60">{{ count($pastClasses) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex items-center gap-2 p-1.5 bg-slate-100 rounded-[12px] w-fit mx-auto border border-slate-200/50 shadow-inner">
        <button @click="activeTab = 'active'" 
                :class="activeTab === 'active' ? 'bg-white text-navy shadow-md ring-1 ring-black/5' : 'text-slate-500 hover:text-navy'"
                class="px-6 py-2.5 rounded-[12px] text-[12px] font-[800] uppercase tracking-widest transition-all">
            Live
        </button>
        <button @click="activeTab = 'upcoming'" 
                :class="activeTab === 'upcoming' ? 'bg-white text-navy shadow-md ring-1 ring-black/5' : 'text-slate-500 hover:text-navy'"
                class="px-6 py-2.5 rounded-[12px] text-[12px] font-[800] uppercase tracking-widest transition-all">
            Upcoming
        </button>
        <button @click="activeTab = 'past'" 
                :class="activeTab === 'past' ? 'bg-white text-navy shadow-md ring-1 ring-black/5' : 'text-slate-500 hover:text-navy'"
                class="px-6 py-2.5 rounded-[12px] text-[12px] font-[800] uppercase tracking-widest transition-all">
            Past
        </button>
    </div>

    <!-- Active Sessions Tab -->
    <div x-show="activeTab === 'active'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="max-w-6xl mx-auto space-y-6">
        @forelse($activeClasses as $class)
            @php
                $isLive = $class->isLive();
                $isEnrolled = in_array($class->course_id, $enrolledCourseIds);
                $startTime = $class->start_time;
            @endphp
            
            <div class="group bg-white rounded-[12px] border border-border shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col md:flex-row items-stretch">
                <!-- Left: Thumbnail & Badges -->
                <div class="relative w-full md:w-[280px] h-[180px] md:h-auto overflow-hidden shrink-0">
                    <img src="{{ $class->course?->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                    
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
                            <span>{{ (int) preg_replace('/[^0-9]/', '', $class->duration) }} Mins</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[280px] p-6 md:p-8 flex flex-col justify-center bg-slate-50/50 group-hover:bg-white transition-colors">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-[12px] bg-navy text-white flex items-center justify-center text-[14px] font-[900] flex-col leading-none shadow-md">
                            <span>{{ $startTime->format('d') }}</span>
                            <span class="text-[9px] uppercase opacity-60">{{ $startTime->format('M') }}</span>
                        </div>
                        <div>
                            <div class="text-navy font-[800] text-[15px]">{{ $startTime->format('g:i A') }}</div>
                            <div class="text-[11px] font-[600] text-muted uppercase tracking-widest italic leading-none mt-1">{{ $startTime->calendar() }}</div>
                        </div>
                    </div>

                    @if($class->liveClassBranch)
                    <div class="mb-4">
                        <div class="inline-flex px-2 py-0.5 bg-emerald-500/10 border border-emerald-500/20 rounded-md text-emerald-600 text-[9px] font-[900] uppercase tracking-widest">
                            <i class="bi bi-people-fill mr-1"></i> {{ $class->liveClassBranch->name }}
                        </div>
                    </div>
                    @endif

                    @php
                        $user = auth()->user();
                        $isPrivileged = $user->is_admin || $user->is_trainer;
                        $studentBatchId = $courseBatchMap[$class->course_id] ?? null;
                        
                        // Access is allowed if:
                        // 1. User is Admin/Trainer
                        // 2. Class has no specific batch (General)
                        // 3. User is in the EXACT batch assigned to this class
                        $hasBatchAccess = $isPrivileged 
                            || $class->live_class_branch_id === null 
                            || (int)$class->live_class_branch_id === (int)$studentBatchId;
                    @endphp

                    @if(!$isEnrolled)
                        <a href="{{ route('courses.show', $class->course_id) }}" class="w-full py-3.5 bg-primary text-white rounded-[12px] font-[800] text-[13px] uppercase tracking-widest shadow-xl shadow-orange-500/20 hover:bg-orange-600 hover:-translate-y-1 transition-all text-center">
                            Enroll to Join
                        </a>
                    @elseif($isLive)
                        @if($hasBatchAccess)
                            <a href="{{ $class->zoom_link }}" target="_blank" class="w-full py-3.5 bg-rose-500 text-white rounded-[12px] font-[800] text-[13px] uppercase tracking-widest shadow-xl shadow-rose-500/20 hover:bg-rose-600 hover:-translate-y-1 transition-all text-center flex items-center justify-center gap-2">
                                Join Now <i class="bi bi-camera-video ml-1"></i>
                            </a>
                        @else
                            <div class="w-full py-3.5 bg-slate-100 text-slate-400 border border-slate-200 rounded-[12px] font-[800] text-[10px] uppercase tracking-widest text-center flex flex-col items-center justify-center cursor-not-allowed">
                                <span class="opacity-60">Reserved for</span>
                                <span class="text-navy">Specific Batch</span>
                            </div>
                        @endif
                    @elseif($class->isEnded())
                        <div class="w-full py-3.5 bg-slate-100 text-slate-400 border border-slate-200 rounded-[12px] font-[800] text-[13px] uppercase tracking-widest text-center flex items-center justify-center gap-2 cursor-not-allowed">
                            Session Ended <i class="bi bi-clock-history"></i>
                        </div>
                    @else
                        <div class="w-full py-3.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-[12px] font-[800] text-[13px] uppercase tracking-widest text-center flex flex-col items-center justify-center">
                            <span class="opacity-40 text-[10px] mb-1">Status</span>
                            <span>On Air</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[12px] p-20 text-center">
                <i class="bi bi-broadcast text-[64px] text-slate-300 block mb-6 px-1"></i>
                <h3 class="text-xl font-[800] text-navy mb-3">No sessions live right now</h3>
                <p class="text-muted font-[500] max-w-sm mx-auto mb-8 px-1">Check the upcoming tab for scheduled sessions or browse our past recordings.</p>
                <button @click="activeTab = 'upcoming'" class="px-10 py-4 bg-navy text-white rounded-[12px] font-[800] uppercase tracking-widest text-[13px] shadow-xl shadow-navy/20">View Upcoming</button>
            </div>
        @endforelse
    </div>

    <!-- Upcoming Sessions Tab -->
    <div x-show="activeTab === 'upcoming'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="max-w-6xl mx-auto space-y-6">
        @forelse($upcomingClasses as $class)
            @php
                $startTime = \Carbon\Carbon::parse($class->start_time);
                $isEnrolled = in_array($class->course_id, $enrolledCourseIds);
            @endphp
            
            <div class="group bg-white rounded-[12px] border border-border shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col md:flex-row items-stretch">
                <div class="relative w-full md:w-[280px] h-[180px] md:h-auto overflow-hidden shrink-0">
                    <img src="{{ $class->course?->thumbnail ?: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=600' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 opacity-80">
                    <div class="absolute inset-0 bg-navy/40 flex flex-col justify-end p-6">
                        @if($isEnrolled)
                        <div class="inline-flex px-3 py-1 bg-primary text-white rounded-full text-[9px] font-[900] uppercase tracking-widest shadow-md w-fit">Subscribed</div>
                        @endif
                    </div>
                </div>

                <div class="flex-1 p-6 md:p-8 flex flex-col justify-center border-b md:border-b-0 md:border-r border-border/50">
                    <div class="text-[11px] font-[900] text-primary uppercase tracking-[0.3em] mb-2">Upcoming Session</div>
                    <h3 class="text-2xl font-[800] text-navy leading-tight mb-4 group-hover:text-primary transition-colors">{{ $class->title }}</h3>
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-2 text-[14px] font-[600] text-muted">
                            <i class="bi bi-person-circle text-primary"></i>
                            <span>{{ $class->instructor_name }}</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[280px] p-6 md:p-8 flex flex-col justify-center bg-slate-50/50 group-hover:bg-white transition-colors">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-[12px] bg-slate-200 text-slate-600 flex items-center justify-center text-[14px] font-[900] flex-col leading-none shadow-sm">
                            <span>{{ $startTime->format('d') }}</span>
                            <span class="text-[9px] uppercase opacity-60">{{ $startTime->format('M') }}</span>
                        </div>
                        <div>
                            <div class="text-navy font-[800] text-[15px]">{{ $startTime->format('g:i A') }}</div>
                            <div class="text-[11px] font-[600] text-muted uppercase tracking-widest leading-none mt-1">{{ $startTime->diffForHumans() }}</div>
                        </div>
                    </div>

                    @if($class->liveClassBranch)
                    <div class="mb-4">
                        <div class="inline-flex px-2 py-0.5 bg-emerald-500/10 border border-emerald-500/20 rounded-md text-emerald-600 text-[9px] font-[900] uppercase tracking-widest">
                            <i class="bi bi-people-fill mr-1"></i> {{ $class->liveClassBranch->name }}
                        </div>
                    </div>
                    @endif

                    @if(!$isEnrolled)
                        <a href="{{ route('courses.show', $class->course_id) }}" class="w-full py-3.5 bg-primary text-white rounded-[12px] font-[800] text-[13px] uppercase tracking-widest shadow-xl shadow-orange-500/20 hover:bg-orange-600 hover:-translate-y-1 transition-all text-center">Enroll Now</a>
                    @else
                        <div class="w-full py-3.5 bg-white text-navy border border-border rounded-[12px] font-[800] text-[13px] uppercase tracking-widest text-center flex flex-col items-center justify-center shadow-sm">
                            <span class="opacity-40 text-[10px] mb-1">Starts In</span>
                            <span>{{ $startTime->diffForHumans(null, true) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[12px] p-20 text-center italic text-muted">No upcoming sessions.</div>
        @endforelse
    </div>

    <!-- Past Sessions Tab -->
    <div x-show="activeTab === 'past'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="space-y-6 max-w-5xl mx-auto">
        @forelse($pastClasses as $class)
            <div class="bg-white p-6 rounded-[12px] border border-border flex flex-col md:flex-row items-center gap-8 group hover:border-primary/20 transition-all">
                <div class="w-full md:w-[200px] h-[120px] rounded-[12px] overflow-hidden shrink-0">
                    <img src="{{ $class->course?->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500">
                </div>
                <div class="flex-1">
                    <div class="text-[10px] font-[900] text-primary uppercase tracking-[0.2em] mb-1">Session Concluded</div>
                    <h4 class="text-xl font-[800] text-navy mb-2">{{ $class->title }}</h4>
                    <div class="flex flex-wrap gap-4 text-[12px] font-[600] text-muted mb-2">
                        <span class="flex items-center gap-1.5"><i class="bi bi-person-badge"></i> {{ $class->instructor_name }}</span>
                        <span class="flex items-center gap-1.5"><i class="bi bi-calendar-check"></i> {{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y') }}</span>
                    </div>
                    @if($class->liveClassBranch)
                    <div class="inline-flex px-2 py-0.5 bg-slate-100 border border-slate-200 rounded-md text-slate-500 text-[9px] font-[900] uppercase tracking-widest">
                        <i class="bi bi-people-fill mr-1"></i> {{ $class->liveClassBranch->name }}
                    </div>
                    @endif
                </div>
                @php
                    $isEnrolled = in_array($class->course_id, $enrolledCourseIds);
                    $studentBatchId = $courseBatchMap[$class->course_id] ?? null;
                    $isPrivileged = auth()->user()->is_admin || auth()->user()->is_trainer;
                    $hasBatchAccess = $isPrivileged 
                        || $class->live_class_branch_id === null 
                        || (int)$class->live_class_branch_id === (int)$studentBatchId;
                @endphp
                <div class="shrink-0 pt-4 md:pt-0">
                    @if($class->recording_url && $isEnrolled && $hasBatchAccess)
                        <a href="{{ $class->recording_url }}" target="_blank" class="px-6 py-3 bg-emerald-600 text-white rounded-[12px] text-[12px] font-[900] uppercase tracking-widest shadow-lg shadow-emerald-500/20 hover:bg-emerald-700 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                            Watch Recording <i class="bi bi-play-circle-fill text-lg"></i>
                        </a>
                    @else
                        <span class="px-5 py-2.5 bg-slate-50 text-slate-400 rounded-full text-[12px] font-[800] uppercase tracking-widest border border-slate-100">Ended</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-slate-50 rounded-[12px] p-16 text-center border-2 border-dashed border-slate-200">
                <h3 class="text-xl font-[800] text-navy text-muted italic">No Past Sessions Yet</h3>
            </div>
        @endforelse
    </div>
</div>
@endsection
