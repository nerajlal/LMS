@extends('layouts.admin')

@section('title', 'My Courses')

@section('content')
<div class="space-y-8">
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-play-circle text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">My <span class="text-primary">Curriculum</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Manage your active course catalog</p>
                </div>
            </div>
            <a href="{{ route('trainer.courses.create') }}" class="px-6 py-3.5 bg-primary text-white font-[900] text-[12px] rounded-[12px] hover:bg-orange-600 transition-all flex items-center gap-3 uppercase tracking-widest shadow-xl shadow-orange-500/20">
                <i class="bi bi-plus-lg text-lg"></i>
                <span>Add New Course</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($courses as $course)
        <div class="group bg-white rounded-[12px] border border-border shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col">
            <div class="relative h-[200px] overflow-hidden">
                <img src="{{ $course->thumbnail ?: 'https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&q=80&w=600' }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $course->title }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute top-[12px] right-[12px] px-[10px] py-[4px] bg-white/20 backdrop-blur-md rounded-[6px] text-[10px] font-[700] text-white uppercase tracking-widest">
                    {{ $course->lessons_count }} Lessons
                </div>
            </div>
            <div class="p-6 flex-1 flex flex-col">
                <h4 class="text-[17px] font-[800] text-navy mb-3 group-hover:text-primary transition-colors line-clamp-2 leading-tight uppercase tracking-tight">{{ $course->title }}</h4>
                
                <div class="flex items-center gap-4 mb-6 text-[11px] font-[700] text-slate-400 uppercase tracking-widest">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-people text-primary"></i> {{ $course->enrollments_count }} Students
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-slate-50">
                    <a href="{{ route('trainer.courses.show', $course->id) }}" class="flex items-center justify-center gap-2 w-full py-3 bg-navy text-white font-[800] rounded-[10px] hover:bg-primary transition-all shadow-lg shadow-navy/10 text-[11px] uppercase tracking-widest">
                        Manage Course <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
