@extends('layouts.admin')

@section('title', 'Schedule Live Class')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <div class="bg-white p-10 rounded-[12px] border border-slate-200 shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-50 rounded-full blur-3xl opacity-50"></div>
        
        <div class="mb-10 relative">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Schedule Class</h1>
            <p class="text-sm text-slate-500 font-medium italic">Create a new interactive learning session for your students</p>
        </div>

        <form action="{{ route('trainer.live-classes.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Target Course</label>
                    <select name="course_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-[#F37021]/20 focus:bg-white transition-all text-sm font-bold appearance-none cursor-pointer">
                        <option value="">-- General / Non-Course Specific --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Session Title</label>
                    <input type="text" name="title" required placeholder="e.g. Weekly Q&A Session" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-[#F37021]/20 focus:bg-white transition-all text-sm font-bold">
                    @error('title') <p class="mt-2 text-xs font-bold text-orange-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Start Time</label>
                        <input type="datetime-local" name="start_time" required 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-[#F37021]/20 focus:bg-white transition-all text-sm font-bold">
                        @error('start_time') <p class="mt-2 text-xs font-bold text-orange-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Duration</label>
                        <input type="text" name="duration" required placeholder="e.g. 60 mins" 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-[#F37021]/20 focus:bg-white transition-all text-sm font-bold">
                        @error('duration') <p class="mt-2 text-xs font-bold text-orange-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Conference Link (Zoom/Google Meet)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 text-lg">
                            <i class="bi bi-link-45deg"></i>
                        </span>
                        <input type="url" name="zoom_link" required placeholder="https://zoom.us/j/..." 
                               class="w-full pl-12 pr-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-[#F37021]/20 focus:bg-white transition-all text-sm font-bold">
                    </div>
                    @error('zoom_link') <p class="mt-2 text-xs font-bold text-orange-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-black text-white rounded-[12px] font-black text-xs uppercase tracking-widest hover:bg-[#F37021] transition-all shadow-xl shadow-slate-900/10 hover:shadow-orange-500/20 active:scale-95 transform">
                    Notify Students & Schedule
                </button>
                <div class="mt-6 flex items-center justify-center gap-2 text-slate-400 italic text-xs font-medium">
                    <i class="bi bi-shield-check text-base"></i>
                    All scheduled classes are visible in the student dashboard instantly.
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
