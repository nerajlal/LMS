@extends('layouts.app')

@section('title', $meta->title . ' - Live Batch')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 lg:px-0" x-data="{ }">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-[11px] font-[700] text-muted uppercase tracking-wider mb-8">
        <a href="{{ route('live-classes.index') }}" class="hover:text-primary">Live Campus</a>
        <i class="bi bi-chevron-right text-[8px]"></i>
        <span class="text-navy">Batch Discovery</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        <!-- Main Content Area -->
        <div class="lg:col-span-8 space-y-12">
            <div>
                @php
                    $videoId = '';
                    if ($branch->course && $branch->course->youtube_link) {
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $branch->course->youtube_link, $match)) {
                            $videoId = $match[1];
                        }
                    }
                @endphp

                @if($videoId)
                <div class="mb-10 rounded-[24px] overflow-hidden shadow-2xl border-4 border-white bg-black aspect-video relative group/trailer">
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <div class="absolute top-4 left-4 pointer-events-none">
                        <span class="px-3 py-1.5 bg-primary text-white text-[10px] font-[900] uppercase tracking-widest rounded-full shadow-lg flex items-center gap-2">
                            <i class="bi bi-play-fill text-[14px]"></i> Batch Preview
                        </span>
                    </div>
                </div>
                @else
                <div class="mb-10 rounded-[28px] overflow-hidden shadow-2xl border-4 border-white bg-slate-100 aspect-video relative">
                    <img src="{{ $meta->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=1200' }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-8">
                         <span class="px-3 py-1 bg-primary text-white text-[9px] font-black uppercase tracking-[0.2em] rounded-full">Interactive Cohort</span>
                    </div>
                </div>
                @endif

                <h1 class="text-[32px] md:text-[44px] font-[900] text-navy tracking-tighter leading-[1.1] mb-6 uppercase">{{ $meta->title }}</h1>
                
                <div class="text-[16px] text-slate-500 font-[500] leading-relaxed mb-10 max-w-4xl italic">
                    {!! nl2br(e($meta->description)) !!}
                </div>

                <div class="flex flex-wrap items-center gap-8 py-6 border-y border-slate-50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-navy text-primary flex items-center justify-center font-[900] border-4 border-slate-50 shadow-sm text-lg">
                            {{ substr($branch->trainers->first()->name ?? 'G', 0, 1) }}
                        </div>
                        <div>
                            <div class="text-slate-400 font-[700] text-[10px] uppercase tracking-widest">Master Mentor</div>
                            <div class="text-navy font-[900] tracking-tight">{{ $branch->trainers->first()->name ?? 'Global Faculty' }}</div>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-slate-100 hidden sm:block"></div>
                    <div class="flex items-center gap-3 text-amber-500">
                        <i class="bi bi-shield-check text-2xl"></i>
                        <div>
                            <div class="text-navy font-[900] text-[15px] tracking-tight">Verified Batch</div>
                            <div class="text-slate-400 font-[700] text-[10px] uppercase tracking-widest">Quality Assured</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learning Outcomes -->
            <div class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-8">
                <h3 class="text-[18px] font-[900] text-navy tracking-tight uppercase tracking-[0.15em]">What you'll achieve</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @if($branch->learning_outcomes)
                        @foreach(explode("\n", $branch->learning_outcomes) as $outcome)
                            @if(trim($outcome))
                            <div class="flex items-start gap-4 text-[14px] text-navy font-[700] leading-snug group">
                                <div class="w-6 h-6 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-[12px] shrink-0 mt-0.5 group-hover:scale-110 transition-transform">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <span class="group-hover:text-primary transition-colors">{{ trim($outcome) }}</span>
                            </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Timeline / Itinerary -->
            @if($branch->liveClasses->isNotEmpty())
            <div class="space-y-8">
                <h3 class="text-[18px] font-[900] text-navy tracking-tight uppercase tracking-[0.15em]">Program Itinerary</h3>
                <div class="space-y-4">
                    @foreach($branch->liveClasses as $index => $session)
                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[20px] border border-transparent hover:border-primary/20 hover:bg-white transition-all group">
                        <div class="flex items-center gap-5">
                            <div class="w-10 h-10 rounded-[12px] bg-white border border-slate-100 flex flex-col items-center justify-center text-navy shrink-0 shadow-sm">
                                <span class="text-[8px] font-black uppercase text-primary">{{ $session->start_time->format('M') }}</span>
                                <span class="text-[16px] font-black leading-none">{{ $session->start_time->format('d') }}</span>
                            </div>
                            <div>
                                <div class="text-[14px] font-[800] text-navy leading-none mb-1 group-hover:text-primary transition-colors">{{ $session->title }}</div>
                                <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest">{{ $session->start_time->format('g:i A') }} • Interactive Session</div>
                            </div>
                        </div>
                        <i class="bi bi-play-circle-fill text-xl text-slate-200 group-hover:text-primary transition-colors"></i>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sticky Enrollment Card -->
        <div class="lg:col-span-4 sticky top-24">
            <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-2xl shadow-navy/5 space-y-8 relative overflow-hidden">
                <div class="relative">
                    <img src="{{ $meta->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" 
                         class="w-full h-[220px] object-cover rounded-[20px] shadow-sm mb-8 border border-slate-100">
                    
                    <div class="flex items-baseline gap-3 mb-3">
                        <span class="text-[42px] font-[900] text-navy tracking-tighter">₹{{ number_format($meta->price) }}</span>
                        @if($meta->price > 0)
                        <span class="text-slate-300 font-[800] line-through text-[18px]">₹{{ number_format($meta->price * 1.4) }}</span>
                        @endif
                        <span class="px-2.5 py-1 bg-red-50 text-red-500 font-[900] text-[10px] uppercase tracking-[0.15em] rounded-[6px] ml-auto border border-red-100">Live Offer</span>
                    </div>

                    <p class="text-[10px] font-[900] text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-2 italic">
                        <i class="bi bi-lightning-charge-fill text-primary"></i> Registration active for limited capacity
                    </p>
                    
                    <a href="{{ route('admissions.express', ['batch_id' => $branch->id]) }}" class="block w-full py-5 bg-primary text-white text-center font-[900] rounded-[16px] hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20 uppercase tracking-[0.2em] text-[13px] mb-8 active:scale-[0.98]">
                        Secure Enrollment
                    </a>
                    
                    <div class="space-y-5 border-t border-slate-50 pt-8">
                        <div class="flex items-center gap-4 text-[13px] font-[800] text-navy">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-sm"><i class="bi bi-camera-video"></i></div>
                            <span>Interactive QA Sessions</span>
                        </div>
                        <div class="flex items-center gap-4 text-[13px] font-[800] text-navy">
                            <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center text-sm"><i class="bi bi-patch-check"></i></div>
                            <span>Institutional Certification</span>
                        </div>
                        <div class="flex items-center gap-4 text-[13px] font-[800] text-navy">
                            <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-sm"><i class="bi bi-record-btn"></i></div>
                            <span>Full Recording Access</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Platform Guarantee -->
            <div class="mt-8 p-6 bg-slate-50 rounded-[24px] border border-slate-100 flex items-center gap-4">
                <i class="bi bi-shield-lock-fill text-3xl text-navy opacity-20"></i>
                <div>
                     <div class="text-[11px] font-[900] text-navy uppercase tracking-widest">Ace Platform Shield</div>
                     <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest leading-relaxed">Encrypted Payment Protocol Enabled</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #fcfcfc; }
</style>
@endsection
