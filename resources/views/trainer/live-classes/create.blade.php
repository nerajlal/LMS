@extends('layouts.admin')

@section('title', 'Schedule Live Class')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-6 space-y-8">
    <!-- High-Density Cinematic Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl group">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-broadcast text-primary text-2xl drop-shadow-[0_0_8px_rgba(243,112,33,0.4)]"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Schedule <span class="text-primary italic">Live</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[11px] font-[600] uppercase tracking-widest mt-0.5 opacity-80">Orchestrate your next interactive session</p>
                </div>
            </div>
            <div>
                <a href="{{ route('trainer.live-classes.index') }}" class="px-5 py-3 bg-white/5 border border-white/10 rounded-[12px] text-[10px] font-[900] uppercase tracking-widest hover:bg-white/10 transition-all flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Back to Batches
                </a>
            </div>
        </div>
    </div>

    <!-- Compact Configuration Core -->
    <div class="bg-white rounded-[20px] border border-slate-200 shadow-xl shadow-navy/5 overflow-hidden">
        <form action="{{ route('trainer.live-classes.store') }}" method="POST" class="p-6 md:p-10 space-y-8">
            @csrf
            
            <!-- Context Section (Row 1) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-[16px] border border-slate-100">
                @if(isset($selectedBranchId))
                    @php $branch = $branches->find($selectedBranchId); @endphp
                    <input type="hidden" name="live_class_branch_id" value="{{ $selectedBranchId }}">
                    <input type="hidden" name="course_id" value="{{ $branch->course_id }}">
                    
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-[10px] bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                            <i class="bi bi-collection-fill"></i>
                        </div>
                        <div class="overflow-hidden">
                            <label class="block text-[9px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-0.5">Assigned Batch</label>
                            <div class="text-[13px] font-[800] text-navy leading-tight truncate">{{ $branch->name ?? 'Selected Batch' }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 border-l border-slate-200 pl-6">
                        <div class="w-10 h-10 rounded-[10px] bg-navy/5 text-navy flex items-center justify-center border border-navy/10">
                            <i class="bi bi-journal-check"></i>
                        </div>
                        <div class="overflow-hidden">
                            <label class="block text-[9px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-0.5">Parent Program</label>
                            <div class="text-[13px] font-[800] text-navy leading-tight truncate">
                                {{ $branch->is_standalone ? 'Independent Live Batch' : ($branch->course->title ?? 'General Course') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div>
                        <label class="block text-[10px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-2 px-1">Target Course (Optional)</label>
                        <div class="relative">
                            <select name="course_id" class="w-full pl-5 pr-10 py-3.5 bg-white border border-border rounded-[12px] focus:border-primary/30 focus:ring-0 transition-all text-[13px] font-[700] text-navy appearance-none cursor-pointer">
                                <option value="">General Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-navy/20 pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-2 px-1">Batch Assignment</label>
                        <div class="relative">
                            <select name="live_class_branch_id" required class="w-full pl-5 pr-10 py-3.5 bg-white border border-border rounded-[12px] focus:border-primary/30 focus:ring-0 transition-all text-[13px] font-[700] text-navy appearance-none cursor-pointer italic">
                                <option value="" disabled selected>-- Select a Batch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-folder2 absolute right-4 top-1/2 -translate-y-1/2 text-navy/20 pointer-events-none"></i>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Session Details (Row 2 & 3) -->
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-2 px-1">Session Title</label>
                    <div class="relative">
                        <input type="text" name="title" required placeholder="e.g. Masterclass: Advanced Laravel Architecture" 
                               class="w-full px-5 py-4 bg-slate-50 border border-transparent rounded-[14px] focus:border-primary/30 focus:bg-white focus:ring-0 transition-all text-[14px] font-[700] text-navy placeholder:text-slate-300">
                        <i class="bi bi-fonts absolute right-5 top-1/2 -translate-y-1/2 text-slate-200 text-lg"></i>
                    </div>
                    @error('title') <p class="mt-2 text-[10px] font-[800] text-primary uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-2 px-1">Start Date & Time</label>
                        <div class="relative">
                            <input type="datetime-local" name="start_time" required 
                                   class="w-full px-5 py-4 bg-slate-50 border border-transparent rounded-[14px] focus:border-primary/30 focus:bg-white focus:ring-0 transition-all text-[14px] font-[700] text-navy cursor-pointer">
                            <i class="bi bi-calendar-event absolute right-5 top-1/2 -translate-y-1/2 text-slate-200 pointer-events-none"></i>
                        </div>
                        @error('start_time') <p class="mt-2 text-[10px] font-[800] text-primary uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-2 px-1">Duration</label>
                        <div class="relative">
                            <input type="text" name="duration" required placeholder="e.g. 60 Mins" 
                                   class="w-full px-5 py-4 bg-slate-50 border border-transparent rounded-[14px] focus:border-primary/30 focus:bg-white focus:ring-0 transition-all text-[14px] font-[700] text-navy">
                            <i class="bi bi-stopwatch absolute right-5 top-1/2 -translate-y-1/2 text-slate-200"></i>
                        </div>
                        @error('duration') <p class="mt-2 text-[10px] font-[800] text-primary uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-navy/[0.02] border border-navy/5 p-6 rounded-[16px]">
                    <label class="block text-[10px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-3 px-1">Conference Link (Zoom/Meet)</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-[8px] flex items-center justify-center text-primary shadow-sm border border-slate-100">
                            <i class="bi bi-link-45deg text-lg rotate-45"></i>
                        </div>
                        <input type="url" name="zoom_link" required placeholder="https://zoom.us/j/session-id-here" 
                               class="w-full pl-16 pr-5 py-4 bg-white border border-slate-200 rounded-[14px] focus:border-primary/30 focus:ring-0 transition-all text-[13px] font-[700] text-navy placeholder:text-slate-300">
                    </div>
                    @error('zoom_link') <p class="mt-3 text-[10px] font-[800] text-primary uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50">
                <button type="submit" class="w-full py-5 bg-navy text-white rounded-[16px] font-[900] text-[12px] uppercase tracking-[0.2em] transition-all hover:bg-primary shadow-lg shadow-navy/10 flex items-center justify-center gap-3">
                    <i class="bi bi-lightning-charge-fill"></i>
                    Deploy Live Session
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    .animate-spin-slow {
        animation: spin 8s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endsection
