@extends('layouts.app')

@section('title', 'Live Interactive Classes - EduLMS')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight">Live Interactive Classes</h1>
            <p class="text-muted mt-1 font-[500]">Join real-time sessions with your instructors and peers</p>
        </div>
        <div class="flex items-center gap-3 px-4 py-2 bg-accent rounded-[12px] border border-primary/10">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-primary"></span>
            </span>
            <span class="text-[13px] font-[700] text-primary uppercase tracking-wider">Live Now Sessions</span>
        </div>
    </div>

    <!-- Live Classes Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @forelse($classes as $class)
        <div class="bg-white rounded-[12px] border border-border shadow-md overflow-hidden flex flex-col md:flex-row group hover:shadow-xl transition-all duration-300">
            <!-- Left: Course Info / Thumbnail -->
            <div class="md:w-[240px] relative shrink-0">
                <div class="absolute inset-0 bg-navy/80 flex flex-col items-center justify-center p-6 text-center space-y-3 z-10">
                    <div class="w-12 h-12 rounded-[12px] bg-primary/20 backdrop-blur-md flex items-center justify-center text-white">
                        <i class="bi bi-camera-video-fill text-2xl"></i>
                    </div>
                    <div class="text-[11px] font-[800] text-primary uppercase tracking-widest">{{ $class->course->title ?? 'N/A' }}</div>
                </div>
                <img src="{{ $class->course->thumbnail ?: 'https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?auto=format&fit=crop&q=80&w=600' }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            </div>

            <!-- Right: Class Details -->
            <div class="flex-1 p-8 flex flex-col">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-[800] text-navy leading-tight group-hover:text-primary transition-colors line-clamp-2">{{ $class->title }}</h3>
                    <span @class([
                        'px-3 py-1 rounded-[8px] text-[10px] font-[800] uppercase tracking-widest',
                        'bg-emerald-50 text-emerald-600' => $class->status === 'live',
                        'bg-amber-50 text-amber-600' => $class->status === 'upcoming',
                        'bg-slate-50 text-slate-500' => $class->status === 'completed',
                    ])>
                        {{ $class->status }}
                    </span>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex items-center gap-3 text-muted text-[14px] font-[500]">
                        <i class="bi bi-person-badge text-primary"></i>
                        <span>Instructor: <span class="text-navy font-[700]">{{ $class->instructor_name }}</span></span>
                    </div>
                    <div class="flex items-center gap-3 text-muted text-[14px] font-[500]">
                        <i class="bi bi-clock text-primary"></i>
                        <span>{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y @ h:i A') }} ({{ $class->duration }} mins)</span>
                    </div>
                </div>

                <div class="mt-auto pt-6 border-t border-border flex items-center justify-between">
                    @if($class->status === 'live')
                        <a href="{{ $class->zoom_link }}" target="_blank" class="flex-1 text-center bg-primary text-white py-3 rounded-[12px] text-[13px] font-[800] uppercase tracking-widest shadow-lg shadow-orange-500/20 hover:bg-orange-600 transition-all">
                            Join Session Now
                        </a>
                    @elseif($class->status === 'upcoming')
                        <button class="flex-1 text-center bg-navy text-white py-3 rounded-[12px] text-[13px] font-[800] uppercase tracking-widest opacity-50 cursor-not-allowed">
                            Starts Soon
                        </button>
                    @else
                        <button class="flex-1 text-center bg-slate-100 text-slate-400 py-3 rounded-[12px] text-[13px] font-[800] uppercase tracking-widest cursor-not-allowed">
                            Session Ended
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="lg:col-span-2 bg-white rounded-[12px] border border-dashed border-slate-200 p-20 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 text-2xl">
                <i class="bi bi-camera-video"></i>
            </div>
            <h3 class="text-lg font-[800] text-navy mb-2">No Live Classes Scheduled</h3>
            <p class="text-muted font-[500]">Check back later for upcoming interactive sessions with our experts.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
