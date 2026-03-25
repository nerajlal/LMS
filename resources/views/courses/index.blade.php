@extends('layouts.app')

@section('title', 'Browser Our Courses - The Ace India')

@section('content')
<div class="space-y-16">
    <!-- Header -->
    <div class="text-center max-w-2xl mx-auto">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-4">Master Your <span class="text-[#F37021]">Future</span></h1>
        <p class="text-slate-500 font-medium">Choose from our curated selection of professional courses designed to take your skills to the next level.</p>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($courses as $course)
        <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-2xl transition-all overflow-hidden flex flex-col">
            <div class="relative h-56 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=800" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute top-4 right-4 flex items-center gap-2">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-bold text-white uppercase tracking-widest">{{ $course->lessons_count }} Lessons</span>
                </div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-[#F37021] transition-colors line-clamp-2 leading-tight">{{ $course->title }}</h4>
                <div class="text-xs font-bold text-slate-400 mb-6 italic">by {{ $course->instructor_name }}</div>
                
                <div class="flex items-center justify-between mt-auto pt-6 border-t border-slate-50">
                    <div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Price</div>
                        <div class="text-2xl font-black text-slate-900">₹{{ number_format($course->price) }}</div>
                    </div>
                    <a href="{{ route('courses.show', $course->id) }}" class="px-6 py-3 bg-slate-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-[#F37021] transition-all transform hover:-translate-y-1 shadow-lg hover:shadow-orange-500/20">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
