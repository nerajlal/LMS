@extends('layouts.admin')

@section('title', 'Schedule Session - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <a href="{{ route('admin.live-classes.index') }}" class="w-12 h-12 bg-white/5 border border-white/10 rounded-[14px] flex items-center justify-center backdrop-blur-md hover:bg-white/10 transition-all">
                    <i class="bi bi-arrow-left text-white text-xl"></i>
                </a>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase leading-none">Session <span class="text-primary">Scheduling</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-2">Initialize new interactive learning event</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-[16px] backdrop-blur-sm">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></div>
                <span class="text-[10px] font-[800] text-slate-300 uppercase tracking-widest">Streaming Interface Protocol</span>
            </div>
        </div>
    </div>

    <!-- Form Console -->
    <div class="bg-white rounded-[24px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden relative group">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-50 rounded-full blur-3xl opacity-30 group-hover:scale-150 transition-transform duration-1000"></div>
        
        <form action="{{ route('admin.live-classes.store') }}" method="POST" class="p-8 md:p-12 relative z-10 space-y-10">
            @csrf
            
            <div class="space-y-8">
                <!-- Course Assignment -->
                <div class="space-y-3">
                    <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Knowledge Vertical (Course)</label>
                    <div class="relative">
                        <i class="bi bi-journal-bookmark absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <select name="course_id" required class="w-full pl-11 pr-12 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[14px] font-[700] text-navy appearance-none outline-none">
                            <option value="">Select Target Curriculum</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Session Identity -->
                <div class="space-y-3">
                    <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Interactive Title</label>
                    <div class="relative">
                        <i class="bi bi-megaphone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="title" required placeholder="e.g. Q&A Session: Advanced System Design Architecture" 
                               class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[14px] font-[700] text-navy outline-none">
                    </div>
                </div>

                <!-- Configuration Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Assigned Instructor</label>
                        <div class="relative">
                            <i class="bi bi-person-badge absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="instructor_name" required placeholder="Instructor Identity" 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Broadcast Schedule</label>
                        <div class="relative">
                            <i class="bi bi-calendar-event absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="datetime-local" name="start_time" required 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Duration (Minutes)</label>
                        <div class="relative">
                            <i class="bi bi-clock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="number" name="duration" required placeholder="e.g. 60" 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Lifecycle Status</label>
                        <div class="relative">
                            <select name="status" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[14px] font-[700] text-navy appearance-none outline-none">
                                <option value="upcoming">Upcoming Deployment</option>
                                <option value="live">Live Transmission</option>
                                <option value="completed">Archive Entry</option>
                            </select>
                            <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <!-- Access Link -->
                <div class="space-y-3">
                    <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Virtual Classroom Link (External)</label>
                    <div class="relative">
                        <i class="bi bi-link-45deg absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="url" name="zoom_link" required placeholder="https://zoom.us/j/..." 
                               class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[14px] font-[700] text-navy outline-none">
                    </div>
                </div>
            </div>

            <!-- Action Section -->
            <div class="pt-8 border-t border-slate-50 flex flex-col sm:flex-row items-center gap-4">
                <button type="submit" class="w-full sm:flex-1 py-5 bg-navy text-white rounded-[16px] font-[900] text-[12px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/10 active:scale-95 transform flex items-center justify-center gap-3">
                    <i class="bi bi-broadcast-pin text-lg"></i>
                    Confirm & Initialize Schedule
                </button>
                <a href="{{ route('admin.live-classes.index') }}" class="w-full sm:w-auto px-10 py-5 bg-slate-100 text-slate-500 rounded-[16px] font-[900] text-[12px] uppercase tracking-[0.2em] hover:bg-slate-200 hover:text-navy transition-all text-center">
                    Discard
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
