@extends('layouts.app')

@section('title', 'Live Interactive Classes - EduLMS')

@section('content')
<div class="space-y-10" x-data="{ activeSection: 'my_batches' }">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[24px] bg-navy p-8 md:p-12 text-white shadow-2xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-[18px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-broadcast text-primary text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-[900] tracking-tight uppercase">Live <span class="text-primary">Campus</span></h1>
                    <p class="text-slate-400 text-[12px] md:text-[14px] font-[600] uppercase tracking-[0.2em] mt-2">Professional Interactive Learning Hub</p>
                </div>
            </div>

            <!-- Global Status Stats -->
            <div class="flex items-center gap-10 md:border-l border-white/10 md:pl-10">
                <div class="flex flex-col">
                    <span class="text-[11px] font-[900] text-emerald-400 uppercase tracking-widest flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_8px_#10b981]"></span>
                        On Air
                    </span>
                    <span class="text-3xl font-[900] text-white">{{ $activeClasses->count() }}</span>
                </div>
                <div class="flex flex-col border-l border-white/10 pl-10 text-center">
                    <span class="text-[11px] font-[900] text-white/40 uppercase tracking-widest mb-1">My Batches</span>
                    <span class="text-3xl font-[900] text-white">{{ $enrolledBatches->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Toggle -->
    <div class="max-w-md mx-auto relative group">
        <div class="flex items-center p-1.5 bg-slate-100 rounded-[18px] border border-slate-200/50 shadow-inner">
            <button @click="activeSection = 'my_batches'" 
                    :class="activeSection === 'my_batches' ? 'bg-white text-navy shadow-sm ring-1 ring-black/5' : 'text-slate-400 hover:text-navy'"
                    class="flex-1 py-3.5 rounded-[14px] text-[12px] font-[900] uppercase tracking-widest transition-all">
                My Batches
            </button>
            <button @click="activeSection = 'all_batches'" 
                    :class="activeSection === 'all_batches' ? 'bg-white text-navy shadow-sm ring-1 ring-black/5' : 'text-slate-400 hover:text-navy'"
                    class="flex-1 py-3.5 rounded-[14px] text-[12px] font-[900] uppercase tracking-widest transition-all">
                All Batches
            </button>
        </div>
    </div>

    <!-- My Batches Section -->
    <div x-show="activeSection === 'my_batches'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            @forelse($enrolledBatches as $batch)
                @php
                    $nextSession = $batch->liveClasses->first();
                    $isLive = $nextSession && $nextSession->isLive();
                    $instructor = $batch->trainers->first();
                @endphp
                <div class="group bg-white rounded-[24px] border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col sm:flex-row">
                    <!-- Column 1: Visual -->
                    <div class="sm:w-1/3 aspect-square sm:aspect-auto relative overflow-hidden">
                        <img src="{{ $batch->course?->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-navy/20 group-hover:bg-transparent transition-all"></div>
                        
                        @if($isLive)
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1.5 bg-rose-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg animate-pulse flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                    LIVE NOW
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Column 2: Data -->
                    <div class="flex-1 p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2.5 py-1 bg-primary/10 text-primary text-[9px] font-black uppercase tracking-wider rounded-md border border-primary/20">
                                    {{ $batch->course?->title ?? 'Professional' }}
                                </span>
                            </div>
                            <h3 class="text-xl font-[900] text-navy mb-1 group-hover:text-primary transition-colors">{{ $batch->name }}</h3>
                            <p class="text-slate-400 text-[11px] font-[700] uppercase tracking-widest mb-6 border-b border-slate-50 pb-4">
                                Lead: {{ $instructor?->name ?? 'Expert Faculty' }}
                            </p>

                            @if($nextSession)
                                <div class="bg-slate-50 p-4 rounded-[16px] border border-slate-100">
                                    <div class="text-[9px] font-[900] text-slate-400 uppercase tracking-[0.2em] mb-2">Upcoming Intelligence</div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-navy text-white flex items-center justify-center text-[11px] font-black flex-col leading-none">
                                            <span>{{ $nextSession->start_time->format('d') }}</span>
                                            <span class="text-[7px] uppercase opacity-60">{{ $nextSession->start_time->format('M') }}</span>
                                        </div>
                                        <div>
                                            <div class="text-navy text-[13px] font-[800]">{{ $nextSession->title }}</div>
                                            <div class="text-[10px] text-slate-400 font-[700]">{{ $nextSession->start_time->format('g:i A') }} • {{ $nextSession->start_time->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-4 bg-slate-50 rounded-[16px] border border-slate-100 italic text-[11px] text-slate-400 font-[600]">
                                    No immediate sessions scheduled for this curriculum.
                                </div>
                            @endif
                        </div>

                        <div class="mt-8">
                            @if($isLive)
                                <a href="{{ $nextSession->zoom_link }}" target="_blank" 
                                   onclick="markAttendance({{ $nextSession->id }})"
                                   class="w-full py-4 bg-rose-500 text-white rounded-[16px] font-[900] text-[12px] uppercase tracking-widest shadow-xl shadow-rose-500/20 hover:bg-rose-600 hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                                    Join Interactive Hall <i class="bi bi-camera-video-fill"></i>
                                </a>
                            @else
                                <button disabled class="w-full py-4 bg-slate-100 text-slate-400 rounded-[16px] font-[900] text-[12px] uppercase tracking-widest cursor-not-allowed border border-slate-200">
                                    Session Pending
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 px-4 text-center bg-slate-50 border-2 border-dashed border-slate-200 rounded-[32px]">
                    <div class="w-20 h-20 bg-white rounded-[24px] shadow-sm border border-slate-200 flex items-center justify-center text-slate-300 mx-auto mb-6 text-3xl">
                        <i class="bi bi-box"></i>
                    </div>
                    <h3 class="text-xl font-[900] text-navy mb-2 uppercase tracking-tight">No Active Enrollments</h3>
                    <p class="text-slate-400 text-sm font-[600] max-w-sm mx-auto mb-8">You haven't joined any live batches yet. Explore our curated catalog to start your learning journey.</p>
                    <button @click="activeSection = 'all_batches'" class="px-8 py-4 bg-navy text-white text-[12px] font-[900] uppercase tracking-widest rounded-[16px] hover:bg-primary transition-all shadow-xl shadow-navy/20">
                        Explore All Batches
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- All Batches Section -->
    <div x-show="activeSection === 'all_batches'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($availableBatches as $batch)
                @php
                    $instructor = $batch->trainers->first();
                    $meta = $batch->getDisplayMetadata();
                @endphp
                <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm hover:shadow-xl transition-all overflow-hidden flex flex-col group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $meta->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/80 to-transparent"></div>
                        <div class="absolute bottom-4 left-6">
                            <span class="text-[9px] font-black text-primary uppercase tracking-[0.2em] block mb-1">Live Program</span>
                            <h4 class="text-lg font-[900] text-white leading-tight">{{ $meta->title }}</h4>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <p class="text-slate-500 text-[13px] font-[600] mb-6 line-clamp-3 italic opacity-80">
                            {{ $meta->description }}
                        </p>
                        
                        <div class="flex items-center justify-between mt-auto pt-6 border-t border-slate-50">
                            <div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 truncate">With {{ $instructor?->name ?? 'Global Expert' }}</div>
                                <div class="text-xl font-black text-navy">₹{{ number_format($meta->price) }}</div>
                            </div>
                            <a href="{{ route('live-classes.batches.show', $batch->id) }}" class="px-6 py-3 bg-navy text-white text-[11px] font-black uppercase tracking-widest rounded-[12px] hover:bg-primary transition-all shadow-lg hover:shadow-orange-500/20">
                                Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center text-slate-400 italic font-[600]">No new batches available at this moment.</div>
            @endforelse
        </div>
    </div>

    <!-- Persistent Artifact: Past Recordings -->
    @if($pastClasses->count() > 0)
    <div class="pt-10 border-t border-slate-100">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-[14px] font-[900] text-navy uppercase tracking-[0.3em]">Curriculum <span class="text-primary">Recordings</span></h3>
            <div class="h-0.5 flex-1 bg-slate-50 mx-10"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pastClasses->take(6) as $class)
                @php
                    $isEnrolled = in_array($class->course_id, $enrolledCourseIds);
                @endphp
                <div class="flex items-center gap-4 p-4 bg-white rounded-[20px] border border-slate-100 hover:border-primary/20 transition-all shadow-sm group">
                    <div class="w-16 h-16 rounded-[14px] overflow-hidden shrink-0 relative">
                        <img src="{{ $class->course?->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=400' }}" class="w-full h-full object-cover">
                        @if($isEnrolled && $class->recording_url)
                            <div class="absolute inset-0 bg-navy/60 flex items-center justify-center text-white">
                                <i class="bi bi-play-fill text-xl"></i>
                            </div>
                        @else
                            <div class="absolute inset-0 bg-slate-100/80 flex items-center justify-center text-slate-400">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-[13px] font-[800] text-navy truncate group-hover:text-primary transition-colors">{{ $class->title }}</h4>
                        <p class="text-[10px] text-slate-400 font-[600] mt-1">{{ $class->start_time->format('M d, Y') }}</p>
                    </div>
                    @if($isEnrolled && $class->recording_url)
                        <a href="{{ $class->recording_url }}" target="_blank" class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100">
                            <i class="bi bi-play-circle-fill"></i>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
    function markAttendance(classId) {
        fetch(`/live-classes/${classId}/attendance`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => console.log('Attendance Logged:', data))
        .catch(error => console.error('Attendance Error:', error));
    }
</script>
@endsection
