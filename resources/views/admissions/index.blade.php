@extends('layouts.app')

@section('title', 'My Learning - The Ace India')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-[900] text-navy tracking-tight uppercase">My Courses</h1>
            <p class="text-muted mt-1 font-[500]">Manage your learning journey and course progress</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('courses.index') }}" class="px-6 py-3 bg-accent text-primary font-[800] text-[12px] uppercase tracking-widest rounded-[12px] hover:bg-primary hover:text-white transition-all shadow-sm">
                Browse More Courses <i class="bi bi-plus-lg ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex items-center gap-8 border-b border-border pb-1">
        <button class="pb-4 px-2 text-[13px] font-[800] uppercase tracking-[0.15em] border-b-2 border-primary text-primary transition-all">
            In Progress
        </button>
        <button class="pb-4 px-2 text-[13px] font-[800] uppercase tracking-[0.15em] border-b-2 border-transparent text-muted hover:text-navy transition-all">
            Completed
        </button>
        <button class="pb-4 px-2 text-[13px] font-[800] uppercase tracking-[0.15em] border-b-2 border-transparent text-muted hover:text-navy transition-all">
            Pending Approval
        </button>
    </div>

    <!-- Course List -->
    <div class="space-y-6">
        @forelse($admissions as $admission)
        <div class="bg-white rounded-[12px] border border-border shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <div class="flex flex-col md:flex-row items-stretch">
                <!-- Course Thumbnail -->
                <div class="md:w-[200px] h-[160px] md:h-auto relative shrink-0 overflow-hidden">
                    <img src="{{ $admission->course->thumbnail ?: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=600' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-navy/20 group-hover:bg-navy/0 transition-colors"></div>
                    
                    @if($admission->status === 'approved')
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 bg-emerald-500 text-white text-[10px] font-[900] uppercase tracking-widest rounded-[8px] shadow-lg">
                            Active
                        </span>
                    </div>
                    @else
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 bg-amber-500 text-white text-[10px] font-[900] uppercase tracking-widest rounded-[8px] shadow-lg">
                            {{ ucfirst($admission->status) }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Course Info -->
                <div class="flex-1 p-8 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div>
                                <h3 class="text-xl font-[900] text-navy leading-tight group-hover:text-primary transition-colors line-clamp-1 mb-1">
                                    {{ $admission->course->title }}
                                </h3>
                                <div class="flex items-center gap-2 text-[10px] font-[800] text-muted uppercase tracking-[0.2em] italic">
                                    by {{ $admission->course->instructor_name }}
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-50 border border-slate-100 rounded-full text-[10px] font-[800] text-navy uppercase tracking-widest shrink-0 shadow-sm">
                                <i class="bi bi-mortarboard text-primary"></i>
                                <span>{{ $admission->batch->name ?? 'Universal' }}</span>
                            </div>
                        </div>
                        <p class="text-[14px] text-muted font-[500] line-clamp-2 mb-6 leading-relaxed">
                            {{ Str::limit($admission->course->description, 120) }}
                        </p>
                    </div>

                    <div class="space-y-6">
                        <!-- Progress Section -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-[11px] font-[900] uppercase tracking-[0.2em]">
                                <span class="text-muted/60">Your Progress</span>
                                <span class="text-primary bg-accent px-2 py-0.5 rounded-[4px]">
                                    @if($admission->status === 'approved')
                                        45% COMPLETE
                                    @else
                                        LOCKED - PENDING
                                    @endif
                                </span>
                            </div>
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden shadow-inner p-[1px]">
                                <div @class([
                                    'h-full rounded-full transition-all duration-1000 shadow-sm relative',
                                    'bg-gradient-to-r from-primary to-orange-400 w-[45%]' => $admission->status === 'approved',
                                    'bg-slate-200 w-0' => $admission->status !== 'approved',
                                ])>
                                    @if($admission->status === 'approved')
                                    <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-slate-50 mt-2">
                            <div class="flex items-center gap-6 text-[12px] font-[800] text-navy/40 uppercase tracking-widest">
                                <span class="flex items-center gap-2">
                                    <i class="bi bi-play-circle-fill text-primary"></i>
                                    {{ $admission->course->lessons_count ?? 0 }} LESSONS
                                </span>
                                <span class="flex items-center gap-2">
                                    <i class="bi bi-folder-fill text-primary"></i>
                                    {{ $admission->course->studyMaterials->count() ?? 0 }} RESOURCES
                                </span>
                            </div>
                            
                            @if($admission->status === 'approved')
                                <a href="{{ route('courses.show', $admission->course_id) }}" class="inline-flex items-center justify-center gap-3 px-8 py-3 bg-navy text-white text-[11px] font-[900] uppercase tracking-[0.2em] rounded-[12px] hover:bg-primary hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-navy/10 group/btn">
                                    CONTINUE LEARNING
                                    <i class="bi bi-arrow-right text-[14px] group-hover/btn:translate-x-1 transition-transform"></i>
                                </a>
                            @else
                                <div class="px-5 py-2.5 bg-amber-50 text-amber-600 text-[10px] font-[900] uppercase tracking-[0.2em] rounded-full flex items-center gap-2 border border-amber-100 animate-pulse">
                                    <i class="bi bi-shield-check"></i> AWAITING ADMISSION APPROVAL
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-[12px] border border-dashed border-border py-24 text-center">
            <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner">
                <i class="bi bi-book"></i>
            </div>
            <h3 class="text-xl font-[800] text-navy mb-2">No active enrollments found</h3>
            <p class="text-muted font-[500] max-w-md mx-auto mb-8">You haven't enrolled in any courses yet. Start your learning journey today by browsing our catalog!</p>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-3 px-10 py-4 bg-primary text-white font-[800] text-[13px] uppercase tracking-widest rounded-[12px] hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20">
                Browse All Courses <i class="bi bi-arrow-right text-lg"></i>
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
