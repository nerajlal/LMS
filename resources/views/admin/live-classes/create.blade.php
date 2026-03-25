@extends('layouts.admin')

@section('title', 'Schedule Live Class - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    <!-- Header -->
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.live-classes.index') }}" class="w-12 h-12 bg-white rounded-[12px] border border-border flex items-center justify-center text-navy hover:text-primary hover:border-primary transition-all shadow-sm">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight">Schedule Session</h1>
            <p class="text-muted mt-1 font-[500]">Create a new live interactive session for students</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-[12px] border border-border shadow-lg p-10">
        <form action="{{ route('admin.live-classes.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Course Selection -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-[11px] font-[800] text-muted uppercase tracking-wider mb-3 pl-1">Target Course</label>
                    <div class="relative">
                        <i class="bi bi-journal-bookmark absolute left-4 top-1/2 -translate-y-1/2 text-primary"></i>
                        <select name="course_id" required class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy appearance-none">
                            <option value="">Select a course for this session</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-muted pointer-events-none"></i>
                    </div>
                </div>

                <!-- Session Title -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-[11px] font-[800] text-muted uppercase tracking-wider mb-3 pl-1">Session Title</label>
                    <input type="text" name="title" required placeholder="e.g. Q&A Session: Mastering Modern Web Design" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                </div>

                <!-- Instructor Name -->
                <div>
                    <label class="block text-[11px] font-[800] text-muted uppercase tracking-wider mb-3 pl-1">Instructor Name</label>
                    <input type="text" name="instructor_name" required placeholder="e.g. Prof. Neraj Lal" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                </div>

                <!-- Start Time -->
                <div>
                    <label class="block text-[11px] font-[800] text-muted uppercase tracking-wider mb-3 pl-1">Start Date & Time</label>
                    <input type="datetime-local" name="start_time" required 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-[11px] font-[800] text-muted uppercase tracking-wider mb-3 pl-1">Duration (Minutes)</label>
                    <input type="number" name="duration" required placeholder="e.g. 60" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-[11px] font-[800] text-muted uppercase tracking-wider mb-3 pl-1">Initial Status</label>
                    <div class="relative">
                        <select name="status" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy appearance-none">
                            <option value="upcoming">Upcoming</option>
                            <option value="live">Live Now</option>
                            <option value="completed">Completed</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-muted pointer-events-none"></i>
                    </div>
                </div>

                <!-- Zoom/Link -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-[11px] font-[800] text-muted uppercase tracking-wider mb-3 pl-1">Session Link (Zoom/Meet)</label>
                    <div class="relative">
                        <i class="bi bi-camera-video absolute left-4 top-1/2 -translate-y-1/2 text-primary"></i>
                        <input type="url" name="zoom_link" required placeholder="https://zoom.us/j/..." 
                               class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-primary text-white font-[800] rounded-[12px] hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20 text-[14px] uppercase tracking-widest">
                    Confirm & Schedule Session
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
