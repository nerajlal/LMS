@extends('layouts.admin')

@section('title', 'My Courses')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Assigned Courses</h1>
            <p class="text-sm text-slate-500 font-medium">Manage your curriculum and student materials</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($courses as $course)
        <div class="group bg-white rounded-[2.5rem] border border-slate-200 shadow-sm hover:shadow-xl transition-all overflow-hidden flex flex-col">
            <div class="relative h-48 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?auto=format&fit=crop&q=80&w=600" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute top-4 right-4 px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-bold text-white uppercase tracking-widest">
                    {{ $course->lessons_count }} Lessons
                </div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <h4 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-[#e3000f] transition-colors line-clamp-2 leading-tight">{{ $course->title }}</h4>
                
                <div class="flex items-center gap-6 mb-8 text-xs font-bold text-slate-400 uppercase tracking-widest">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-people text-base"></i> {{ $course->enrollments_count }} Students
                    </div>
                </div>

                <div class="mt-auto">
                    <a href="{{ route('trainer.courses.show', $course->id) }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-900 text-white font-black rounded-2xl hover:bg-[#e3000f] transition-all shadow-lg hover:shadow-red-500/20 text-xs uppercase tracking-widest">
                        Manage Content <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
