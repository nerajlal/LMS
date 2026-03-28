@extends('layouts.admin')

@section('title', 'Schedule Live Class')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-6">
    <!-- Cinematic Banner -->
    <div class="relative overflow-hidden rounded-[24px] bg-navy p-10 md:p-14 text-white shadow-2xl mb-12 group">
        <div class="absolute top-[-40px] right-[-40px] w-[300px] h-[300px] bg-primary/20 rounded-full blur-[100px] group-hover:scale-110 transition-transform duration-1000"></div>
        <div class="absolute bottom-[-20px] left-[-20px] w-[150px] h-[150px] bg-blue-500/10 rounded-full blur-[60px]"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
            <div class="w-24 h-24 rounded-[28px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-xl shadow-2xl animate-float">
                <i class="bi bi-broadcast text-primary text-5xl drop-shadow-[0_0_15px_rgba(243,112,33,0.5)]"></i>
            </div>
            <div class="text-center md:text-left">
                <div class="inline-flex px-4 py-1.5 bg-primary/20 border border-primary/30 rounded-full text-primary text-[10px] font-[900] uppercase tracking-[0.3em] mb-4">
                    Live Engine v2.0
                </div>
                <h1 class="text-3xl md:text-5xl font-[900] tracking-tight text-white uppercase leading-none">Schedule <span class="text-primary italic">Live</span></h1>
                <p class="text-slate-400 text-[12px] md:text-[14px] font-[600] uppercase tracking-[0.2em] mt-4 opacity-80">Orchestrate your next interactive learning journey</p>
            </div>
        </div>
    </div>

    <!-- Main Configuration Core -->
    <div class="bg-white rounded-[32px] border border-slate-200 shadow-2xl shadow-navy/5 overflow-hidden relative">
        <div class="absolute top-0 right-0 p-8">
            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-200">
                <i class="bi bi-gear-fill text-xl animate-spin-slow"></i>
            </div>
        </div>

        <form action="{{ route('trainer.live-classes.store') }}" method="POST" class="p-8 md:p-16 space-y-12">
            @csrf
            
            <!-- Context Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-12 border-b border-slate-100">
                @if(isset($selectedCourseId))
                    <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
                    <div class="group">
                        <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-4 px-1">Selected Program</label>
                        <div class="px-8 py-5 bg-slate-50 border-2 border-slate-100 rounded-[22px] transition-all group-hover:border-primary/20 group-hover:bg-white">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-[14px] bg-navy text-white flex items-center justify-center shadow-lg">
                                    <i class="bi bi-journal-check text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-[14px] font-[900] text-navy leading-tight">{{ $courses->find($selectedCourseId)->title ?? 'General Course' }}</div>
                                    <div class="text-[10px] text-primary font-[800] uppercase tracking-widest mt-1">Course Inheritance Active</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="group">
                        <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-4 px-1">Target Course</label>
                        <div class="relative">
                            <select name="course_id" class="w-full pl-8 pr-14 py-5 bg-slate-50 border-2 border-transparent rounded-[22px] focus:border-primary/30 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy appearance-none hover:bg-slate-100 cursor-pointer">
                                <option value="">General Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down absolute right-8 top-1/2 -translate-y-1/2 text-navy/30 pointer-events-none group-hover:text-primary transition-colors"></i>
                        </div>
                    </div>
                @endif

                @if(isset($selectedBranchId))
                    <input type="hidden" name="live_class_branch_id" value="{{ $selectedBranchId }}">
                    <div class="group">
                        <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-4 px-1">Target Batch</label>
                        <div class="px-8 py-5 bg-emerald-50/50 border-2 border-emerald-100/50 rounded-[22px] transition-all group-hover:border-emerald-200 group-hover:bg-white">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-[14px] bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-inner">
                                    <i class="bi bi-collection-fill text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-[14px] font-[900] text-navy leading-tight">{{ $branches->find($selectedBranchId)->name ?? 'Selected Batch' }}</div>
                                    <div class="text-[10px] text-emerald-600 font-[800] uppercase tracking-widest mt-1">Direct Batch Context</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="group">
                        <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-4 px-1">Live Class Batch</label>
                        <div class="relative">
                            <select name="live_class_branch_id" required class="w-full pl-8 pr-14 py-5 bg-slate-50 border-2 border-transparent rounded-[22px] focus:border-primary/30 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy appearance-none hover:bg-slate-100 cursor-pointer italic">
                                <option value="" disabled selected>-- Select a Batch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-folder-fill absolute right-8 top-1/2 -translate-y-1/2 text-navy/30 pointer-events-none group-hover:text-primary transition-colors"></i>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Session Info -->
            <div class="space-y-10 pt-4">
                <div class="group">
                    <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-4 px-1">Masterclass Title</label>
                    <div class="relative">
                        <input type="text" name="title" required placeholder="e.g. Masterclass: Advanced Laravel Systems" 
                               class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent rounded-[22px] focus:border-primary/30 focus:bg-white focus:ring-0 transition-all text-[16px] font-[700] text-navy placeholder:text-slate-300">
                        <div class="absolute right-8 top-1/2 -translate-y-1/2 group-focus-within:text-primary text-slate-200 transition-colors">
                            <i class="bi bi-type-h1 text-2xl"></i>
                        </div>
                    </div>
                    @error('title') <p class="mt-3 text-[11px] font-[800] text-primary uppercase tracking-widest flex items-center gap-2"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="group">
                        <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-4 px-1">Launch Date & Time</label>
                        <div class="relative">
                            <input type="datetime-local" name="start_time" required 
                                   class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent rounded-[22px] focus:border-primary/30 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy">
                            <div class="absolute right-8 top-1/2 -translate-y-1/2 group-focus-within:text-primary text-slate-200 pointer-events-none">
                                <i class="bi bi-calendar3 text-xl"></i>
                            </div>
                        </div>
                        @error('start_time') <p class="mt-3 text-[11px] font-[800] text-primary uppercase tracking-widest flex items-center gap-2"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p> @enderror
                    </div>
                    <div class="group">
                        <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-4 px-1">Duration Runtime</label>
                        <div class="relative">
                            <input type="text" name="duration" required placeholder="e.g. 90 Minutes" 
                                   class="w-full px-8 py-5 bg-slate-50 border-2 border-transparent rounded-[22px] focus:border-primary/30 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy">
                            <div class="absolute right-8 top-1/2 -translate-y-1/2 group-focus-within:text-primary text-slate-200">
                                <i class="bi bi-clock-history text-xl"></i>
                            </div>
                        </div>
                        @error('duration') <p class="mt-3 text-[11px] font-[800] text-primary uppercase tracking-widest flex items-center gap-2"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="group bg-navy/5 p-8 md:p-10 rounded-[28px] border-2 border-dashed border-slate-200 hover:border-primary/30 transition-colors">
                    <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-6 px-1">Teleconference Access (Zoom / Meet / Teams)</label>
                    <div class="relative">
                        <div class="absolute left-8 top-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-[14px] flex items-center justify-center text-primary shadow-lg border border-slate-100">
                            <i class="bi bi-link-45deg text-2xl rotate-45"></i>
                        </div>
                        <input type="url" name="zoom_link" required placeholder="https://zoom.us/j/session-id-here" 
                               class="w-full pl-24 pr-8 py-5 bg-white border-2 border-slate-100 rounded-[22px] focus:border-primary/30 focus:ring-0 transition-all text-[15px] font-[700] text-navy placeholder:text-slate-300">
                    </div>
                    @error('zoom_link') <p class="mt-4 text-[11px] font-[800] text-primary uppercase tracking-widest flex items-center gap-2 px-2"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p> @enderror
                    <div class="mt-4 flex items-center gap-3 px-2">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center text-[10px] text-emerald-600">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest">Secure link used for student redirection only</p>
                    </div>
                </div>
            </div>

            <div class="pt-8">
                <button type="submit" class="w-full group/btn relative overflow-hidden py-6 bg-navy text-white rounded-[24px] font-[900] text-[14px] uppercase tracking-[0.3em] transition-all hover:scale-[1.02] active:scale-[0.98] shadow-2xl shadow-navy/20">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary to-orange-400 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500"></div>
                    <div class="relative z-10 flex items-center justify-center gap-4">
                        <i class="bi bi-lightning-charge-fill text-xl"></i>
                        Deploy Live Session
                    </div>
                </button>
                <div class="mt-10 flex items-center justify-center gap-8 py-6 border-t border-slate-50 opacity-40 grayscale group-hover:grayscale-0 transition-all">
                    <i class="bi bi-zoom text-2xl"></i>
                    <i class="bi bi-google text-2xl"></i>
                    <i class="bi bi-microsoft text-2xl"></i>
                </div>
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
