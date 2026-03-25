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
                <div class="flex-1 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-4 mb-2">
                            <h3 class="text-lg font-[800] text-navy leading-tight group-hover:text-primary transition-colors line-clamp-1">
                                {{ $admission->course->title }}
                            </h3>
                            <div class="flex items-center gap-1 text-[10px] font-[800] text-muted uppercase tracking-widest shrink-0">
                                <i class="bi bi-mortarboard text-primary"></i>
                                <span>{{ $admission->batch->name ?? 'Universal' }}</span>
                            </div>
                        </div>
                        <p class="text-[13px] text-muted font-[500] line-clamp-1 mb-4">
                            {{ Str::limit($admission->course->description, 100) }}
                        </p>
                    </div>

                    <div class="space-y-4">
                        <!-- Progress Section -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-[11px] font-[800] uppercase tracking-widest">
                                <span class="text-muted">Course Progress</span>
                                <span class="text-navy">
                                    @if($admission->status === 'approved')
                                        45% Completed
                                    @else
                                        0% - Awaiting Start
                                    @endif
                                </span>
                            </div>
                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div @class([
                                    'h-full transition-all duration-1000',
                                    'bg-primary w-[45%]' => $admission->status === 'approved',
                                    'bg-slate-200 w-0' => $admission->status !== 'approved',
                                ])></div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-3 border-t border-border mt-1">
                            <div class="flex items-center gap-4 text-[12px] font-[700] text-muted">
                                <span class="flex items-center gap-1.5">
                                    <i class="bi bi-journal-text text-primary"></i>
                                    {{ $admission->course->lessons_count ?? 0 }} Lessons
                                </span>
                            </div>
                            
                            @if($admission->status === 'approved')
                                <a href="{{ route('courses.show', $admission->course_id) }}" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-navy text-white text-[11px] font-[800] uppercase tracking-widest rounded-[10px] hover:bg-primary transition-all shadow-xl shadow-navy/10 group/btn">
                                    Resume Course
                                    <i class="bi bi-arrow-right group-hover/btn:translate-x-1 transition-transform"></i>
                                </a>
                            @else
                                <span class="text-[11px] font-[800] text-amber-500 uppercase tracking-widest italic flex items-center gap-2">
                                    <i class="bi bi-clock-history"></i> Verification in progress
                                </span>
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
