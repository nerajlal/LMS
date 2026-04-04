@extends('layouts.app')

@section('title', 'My Learning - The Ace India')

@section('content')
<div class="space-y-8" x-data="{ activeTab: '{{ count($inProgress) > 0 ? 'ongoing' : 'done' }}' }">
    <!-- Compact Cinematic Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[150px] h-[150px] bg-primary/20 rounded-full blur-[60px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[12px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-person-workspace text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-[900] tracking-tight">Recorded <span class="text-primary">Library</span></h1>
                    <p class="text-slate-400 text-[12px] font-[600] uppercase tracking-widest mt-0.5">Welcome back, {{ auth()->user()->name }}</p>
                </div>
            </div>

            <!-- Inline Stats -->
            <div class="flex items-center gap-4 sm:gap-8 md:border-l border-white/10 md:pl-8">
                <div class="flex flex-col">
                    <span class="text-[9px] md:text-[10px] font-[800] text-white/40 uppercase tracking-widest whitespace-nowrap">Courses Ongoing</span>
                    <span class="text-lg md:text-xl font-[900] text-primary">{{ $stats['in_progress'] }}</span>
                </div>
                <div class="flex flex-col border-l border-white/10 pl-4 sm:pl-8">
                    <span class="text-[9px] md:text-[10px] font-[800] text-white/40 uppercase tracking-widest whitespace-nowrap">Completed</span>
                    <span class="text-lg md:text-xl font-[900] text-emerald-400">{{ $stats['completed'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-2 p-1 md:p-1.5 bg-slate-100 rounded-[12px] shadow-inner border border-slate-200/50 w-full md:w-auto overflow-x-auto no-scrollbar whitespace-nowrap">
            <button @click="activeTab = 'ongoing'" 
                    :class="activeTab === 'ongoing' ? 'bg-white text-navy shadow-md ring-1 ring-black/5' : 'text-slate-500 hover:text-navy'"
                    class="flex-1 md:flex-none px-4 md:px-6 py-2 md:py-2.5 rounded-[10px] text-[11px] md:text-[12px] font-[800] uppercase tracking-widest transition-all focus:outline-none">
                In Progress
            </button>
            <button @click="activeTab = 'done'" 
                    :class="activeTab === 'done' ? 'bg-white text-navy shadow-md ring-1 ring-black/5' : 'text-slate-500 hover:text-navy'"
                    class="flex-1 md:flex-none px-4 md:px-6 py-2 md:py-2.5 rounded-[10px] text-[11px] md:text-[12px] font-[800] uppercase tracking-widest transition-all focus:outline-none">
                Completed
            </button>
        </div>

        <a href="{{ route('courses.index') }}" class="text-[12px] font-[800] text-primary uppercase tracking-widest hover:underline flex items-center gap-2">
            Browse All Courses <i class="bi bi-chevron-right"></i>
        </a>
    </div>

    <!-- Tab Contents -->
    <div class="space-y-8">
        <!-- In Progress Tab -->
        <div x-show="activeTab === 'ongoing'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="space-y-6">
            @forelse($inProgress as $admission)
                <div class="group bg-white rounded-[12px] border border-border shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col md:flex-row items-stretch">
                    <div class="relative w-full md:w-[280px] h-[200px] md:h-auto overflow-hidden shrink-0 bg-gradient-to-br from-navy to-slate-800">
                        <img src="{{ $admission->course?->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 opacity-90"
                             onerror="this.style.display='none'">
                        <div class="absolute inset-0 bg-gradient-to-r from-navy/60 to-transparent flex flex-col justify-end p-6">
                            <span class="inline-flex px-3 py-1 bg-primary text-white text-[9px] font-[900] uppercase tracking-widest rounded-full shadow-lg w-fit">
                                Self-Paced
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 p-5 md:p-8 flex flex-col justify-between border-b md:border-b-0 md:border-r border-border/50">
                        <div>
                            <div class="text-[10px] md:text-[11px] font-[900] text-primary uppercase tracking-[0.3em] mb-2">{{ $admission->course?->category ?? 'Specialization' }}</div>
                            <h3 class="text-xl md:text-2xl font-[800] text-navy mb-4 group-hover:text-primary transition-colors leading-tight">
                                {{ $admission->course?->title ?? 'Technical Program' }}
                            </h3>
                            <div class="flex items-center gap-6 mb-6">
                                <div class="flex items-center gap-2 text-[13px] font-[600] text-muted">
                                    <i class="bi bi-play-circle text-primary"></i> 
                                    {{ ($admission->course?->lessons_count ?? 0) . ' Lessons' }}
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-[11px] font-[900] uppercase tracking-widest text-muted">
                                <span>Curriculum Progress</span>
                                <span class="text-navy">{{ $admission->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden shadow-inner relative">
                                <div class="h-full bg-gradient-to-r from-primary to-orange-400 rounded-full transition-all duration-1000" style="width: {{ $admission->progress ?? 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-[260px] p-5 md:p-8 flex flex-col justify-center bg-slate-50/50 group-hover:bg-white transition-colors">
                        <a href="{{ route('courses.show', $admission->course_id) }}" class="w-full py-3.5 bg-navy text-white rounded-[12px] font-[800] text-[12px] md:text-[13px] uppercase tracking-widest shadow-xl shadow-navy/20 hover:bg-primary transition-all text-center">
                            Continue <i class="bi bi-arrow-right-short text-lg"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[12px] p-20 text-center">
                    <h3 class="text-xl font-[800] text-navy mb-3">No ongoing courses</h3>
                    <p class="text-muted font-[500] max-w-sm mx-auto mb-8">Ready to add something new to your library?</p>
                    <a href="{{ route('courses.index') }}" class="px-10 py-4 bg-primary text-white rounded-[12px] font-[800] uppercase tracking-widest text-[13px] shadow-xl shadow-orange-500/20">Explore Catalog</a>
                </div>
            @endforelse
        </div>

        <!-- Completed Tab -->
        <div x-show="activeTab === 'done'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($completed as $admission)
                <div class="bg-white p-6 rounded-[12px] border border-border shadow-sm flex items-center gap-6 group hover:border-emerald-500/20 transition-all">
                    <div class="w-24 h-24 rounded-[12px] overflow-hidden shrink-0 grayscale group-hover:grayscale-0 transition-all shadow-md bg-gradient-to-br from-navy to-slate-800">
                        <img src="{{ $admission->course?->thumbnail }}" 
                             class="w-full h-full object-cover opacity-90"
                             onerror="this.style.display='none'">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[10px] font-[900] text-emerald-500 uppercase tracking-widest mb-1">Course Completed</div>
                        <h4 class="text-lg font-[800] text-navy truncate group-hover:text-emerald-600 mb-2">{{ $admission->course?->title }}</h4>
                        <div class="flex items-center gap-4 text-[12px] font-[600] text-muted">
                            @if($admission->certificate_path)
                                <a href="{{ asset('storage/' . $admission->certificate_path) }}" target="_blank" class="flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 hover:underline">
                                    <i class="bi bi-award-fill text-lg"></i> Download Certificate
                                </a>
                            @elseif($admission->latestExamResult && $admission->latestExamResult->status === 'passed')
                                <span class="flex items-center gap-2 text-primary font-[900] uppercase tracking-widest text-[10px]">
                                    <i class="bi bi-hourglass-split animate-spin-slow"></i> Processing Certificate
                                </span>
                            @else
                                <a href="{{ route('courses.exam.show', $admission->course_id) }}" class="flex items-center gap-2 px-4 py-2 bg-navy text-white rounded-[10px] text-[10px] font-[900] uppercase tracking-widest hover:bg-primary transition-all shadow-lg active:scale-[0.95]">
                                    <i class="bi bi-mortarboard"></i> Take Assessment
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 bg-slate-50 rounded-[12px] p-16 text-center border-2 border-dashed border-slate-200">
                    <h3 class="text-xl font-[800] text-navy">No accomplishments yet</h3>
                </div>
            @endforelse
        </div>

    </div>
</div>
</div>
@endsection
