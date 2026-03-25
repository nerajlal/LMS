@extends('layouts.app')

@section('title', $course->title . ' - The Ace India')

@section('content')
<div x-data="{ 
    isEnrolled: {{ $isEnrolled ? 'true' : 'false' }},
    activeVideo: '{{ count($course->lessons) > 0 ? $course->lessons[0]->video_url : "" }}',
    activeTitle: '{{ count($course->lessons) > 0 ? $course->lessons[0]->title : "Select a lesson" }}'
}">
    
    @if($isEnrolled)
    <!-- LEARNING VIEW (Enrolled) -->
    <div class="space-y-10">
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Video Player Area -->
            <div class="lg:col-span-2 flex-1 space-y-6">
                <div class="aspect-video bg-black rounded-[2.5rem] overflow-hidden shadow-2xl relative border-4 border-white">
                    <template x-if="activeVideo">
                        <iframe :src="activeVideo" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </template>
                    <template x-if="!activeVideo">
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-500 space-y-4">
                            <i class="bi bi-play-circle text-6xl opacity-20"></i>
                            <p class="font-bold text-lg">Select a lesson to start learning</p>
                        </div>
                    </template>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight" x-text="activeTitle"></h1>
                    <p class="text-sm text-slate-500 font-medium mt-2 italic">Part of: {{ $course->title }}</p>
                </div>
            </div>

            <!-- Curriculum Sidebar -->
            <div class="w-full lg:w-96 shrink-0 space-y-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden flex flex-col h-full max-h-[600px]">
                    <div class="p-8 border-b border-slate-50">
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Course Curriculum</h3>
                        <div class="text-[10px] font-black text-[#F37021] uppercase tracking-widest mt-1">{{ count($course->lessons) }} Total Lessons</div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-2">
                        @foreach($course->lessons as $index => $lesson)
                        <button @click="activeVideo = '{{ $lesson->video_url }}'; activeTitle = '{{ $lesson->title }}'" 
                                :class="activeVideo === '{{ $lesson->video_url }}' ? 'bg-red-50 border-red-100' : 'hover:bg-slate-50 border-transparent'"
                                class="w-full flex items-center gap-4 p-4 rounded-2xl border transition-all text-left group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm shrink-0 transition-colors"
                                 :class="activeVideo === '{{ $lesson->video_url }}' ? 'bg-[#F37021] text-white shadow-lg shadow-orange-500/20' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200'">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-slate-900 truncate leading-tight mb-1" :class="activeVideo === '{{ $lesson->video_url }}' ? 'text-[#F37021]' : ''">{{ $lesson->title }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Video Lesson</div>
                            </div>
                            <i class="bi bi-play-circle-fill text-xl text-slate-200 group-hover:text-[#F37021] transition-all" :class="activeVideo === '{{ $lesson->video_url }}' ? 'text-[#F37021] scale-110' : ''"></i>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- MARKETING VIEW (Not Enrolled) -->
    <div class="max-w-5xl mx-auto py-10">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-16 items-start">
            <div class="lg:col-span-3 space-y-10">
                <div>
                    <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">
                        <a href="{{ route('courses.index') }}" class="hover:text-[#F37021]">Courses</a>
                        <i class="bi bi-chevron-right text-[8px]"></i>
                        <span class="text-slate-900">Featured Course</span>
                    </nav>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tight leading-[1.1] mb-6">{{ $course->title }}</h1>
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-[#F37021] font-black border-2 border-white shadow-sm">
                                {{ substr($course->instructor_name, 0, 1) }}
                            </div>
                            <div class="text-sm">
                                <div class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">Instructor</div>
                                <div class="text-slate-900 font-black">{{ $course->instructor_name }}</div>
                            </div>
                        </div>
                        <div class="h-8 w-px bg-slate-200"></div>
                        <div class="flex items-center gap-2 text-amber-500 text-xl">
                            <i class="bi bi-star-fill"></i>
                            <span class="text-slate-900 font-black text-lg">4.9 <span class="text-slate-400 font-bold text-sm">(124)</span></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-6">
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">What you'll learn</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(['Foundational Principles', 'Real-world Projects', 'Industry Best Practices', 'Advanced Techniques'] as $benefit)
                        <div class="flex items-center gap-3 text-slate-600 font-medium">
                            <div class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs shrink-0"><i class="bi bi-check-lg"></i></div>
                            {{ $benefit }}
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Curriculum Preview</h3>
                    <div class="space-y-3">
                        @foreach($course->lessons->take(3) as $index => $lesson)
                        <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-transparent hover:border-slate-200 transition-all">
                            <div class="flex items-center gap-4">
                                <i class="bi bi-play-circle text-slate-400 text-xl"></i>
                                <span class="text-sm font-bold text-slate-700 leading-none">{{ $lesson->title }}</span>
                            </div>
                            <span class="text-[10px] font-black text-[#F37021] uppercase tracking-widest">Preview</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sticky Enrollment Card -->
            <div class="lg:col-span-2 sticky top-24">
                <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-2xl space-y-8 relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-50 rounded-full blur-3xl opacity-50"></div>
                    
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600" class="w-full h-48 object-cover rounded-[2rem] shadow-lg mb-8">
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-4xl font-black text-slate-900 tracking-tight">₹{{ number_format($course->price) }}</span>
                            <span class="text-slate-400 font-bold line-through text-lg">₹{{ number_format($course->price * 1.5) }}</span>
                            <span class="text-[#F37021] font-black text-sm uppercase tracking-widest ml-auto">30% OFF</span>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">Lifetime access with one-time payment</p>
                        
                        <a href="{{ route('admissions.create', ['course_id' => $course->id]) }}" class="block w-full py-5 bg-[#F37021] text-white text-center font-black rounded-2xl hover:bg-[#E6631E] transition-all transform hover:-translate-y-1 shadow-xl shadow-red-500/30 uppercase tracking-widest mb-4">
                            Enroll in Course
                        </a>
                        
                        <div class="space-y-4 pt-4">
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-700">
                                <i class="bi bi-infinite text-[#F37021] text-lg"></i> Lifetime Access
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-700">
                                <i class="bi bi-patch-check text-[#F37021] text-lg"></i> Certificate of Completion
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold text-slate-700">
                                <i class="bi bi-phone text-[#F37021] text-lg"></i> Access on mobile and TV
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
