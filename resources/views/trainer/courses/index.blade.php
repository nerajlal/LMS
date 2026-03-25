@extends('layouts.admin')

@section('title', 'My Courses')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-[24px] font-[800] text-navy tracking-tight">Assigned Courses</h1>
            <p class="text-muted mt-1 font-[500] text-[14px]">Manage your curriculum and student materials</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($courses as $course)
        <div class="group bg-white rounded-[12px] border border-border shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col">
            <div class="relative h-[200px] overflow-hidden">
                <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&q=80&w=600" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                <div class="absolute top-[12px] right-[12px] px-[10px] py-[4px] bg-white/20 backdrop-blur-md rounded-[6px] text-[10px] font-[700] text-white uppercase tracking-widest">
                    {{ $course->lessons_count }} Lessons
                </div>
            </div>
            <div class="p-[24px] flex-1 flex flex-col">
                <h4 class="text-[18px] font-[800] text-navy mb-[12px] group-hover:text-primary transition-colors line-clamp-2 leading-tight">{{ $course->title }}</h4>
                
                <div class="flex items-center gap-[16px] mb-[24px] text-[12px] font-[600] text-muted uppercase tracking-wider">
                    <div class="flex items-center gap-[8px]">
                        <i class="bi bi-people text-[16px] text-primary"></i> {{ $course->enrollments_count }} Students
                    </div>
                </div>

                <div class="mt-auto">
                    <a href="{{ route('trainer.courses.show', $course->id) }}" class="flex items-center justify-center gap-[10px] w-full py-[12px] bg-navy text-white font-[700] rounded-[8px] hover:bg-primary transition-all shadow-sm text-[13px] uppercase tracking-wider">
                        Manage Content <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
