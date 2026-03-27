@extends('layouts.admin')

@section('title', 'Schedule Live Class')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="flex items-center gap-6 mb-10">
        <a href="{{ route('trainer.live-classes.index') }}" class="w-12 h-12 rounded-[14px] bg-white border border-slate-200 flex items-center justify-center text-navy hover:text-primary transition-all shadow-sm group">
            <i class="bi bi-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
        </a>
        <div>
            <h1 class="text-3xl font-[900] text-navy tracking-tight uppercase leading-none">Schedule <span class="text-primary">Session</span></h1>
            <p class="text-muted text-[13px] font-[600] mt-2 uppercase tracking-widest opacity-70">Create a new interactive learning experience</p>
        </div>
    </div>

    <div class="bg-white p-8 md:p-12 rounded-[20px] border border-slate-200 shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-orange-50 rounded-full blur-[80px] opacity-60"></div>
        
        <form action="{{ route('trainer.live-classes.store') }}" method="POST" class="space-y-10 relative z-10">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-3 px-1">Target Course</label>
                    <div class="relative">
                        <select name="course_id" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy appearance-none cursor-pointer">
                            <option value="">-- General / Non-Course Specific --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-navy/30 pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-3 px-1">Session Title</label>
                    <input type="text" name="title" required placeholder="e.g. Masterclass: Advanced Laravel Architecture" 
                           class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy placeholder:text-slate-300">
                    @error('title') <p class="mt-2 text-[12px] font-[800] text-primary uppercase tracking-wider italic">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-3 px-1">Start Time</label>
                        <input type="datetime-local" name="start_time" required 
                               class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy">
                        @error('start_time') <p class="mt-2 text-[12px] font-[800] text-primary uppercase tracking-wider italic">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-3 px-1">Duration</label>
                        <div class="relative">
                            <input type="text" name="duration" required placeholder="e.g. 60 mins" 
                                   class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy">
                            <i class="bi bi-clock absolute right-6 top-1/2 -translate-y-1/2 text-navy/20"></i>
                        </div>
                        @error('duration') <p class="mt-2 text-[12px] font-[800] text-primary uppercase tracking-wider italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-3 px-1">Conference Link (Zoom/Meet)</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-primary">
                            <i class="bi bi-camera-video-fill text-xl"></i>
                        </span>
                        <input type="url" name="zoom_link" required placeholder="https://zoom.us/j/..." 
                               class="w-full pl-16 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy placeholder:text-slate-300">
                    </div>
                    @error('zoom_link') <p class="mt-2 text-[12px] font-[800] text-primary uppercase tracking-wider italic">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100">
                <button type="submit" class="w-full py-5 bg-navy text-white rounded-[14px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20 hover:shadow-orange-500/30 active:scale-[0.98] transform flex items-center justify-center gap-3">
                    <i class="bi bi-broadcast text-xl"></i>
                    Schedule & Notify Students
                </button>
                <div class="mt-8 flex items-center justify-center gap-3 px-6 py-4 bg-slate-50 rounded-[12px] border border-slate-100">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                    <p class="text-[11px] text-slate-500 font-[700] uppercase tracking-wider leading-none">Session becomes visible to students instantly</p>
                </div>
            </div>
        </form>
    </div>
</div>
        </form>
    </div>
</div>
@endsection
