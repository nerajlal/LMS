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
    <div class="space-y-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Video Player Area -->
            <div class="lg:col-span-2 flex-1 space-y-6">
                <div class="aspect-video bg-black rounded-[12px] overflow-hidden shadow-lg relative border-border">
                    <template x-if="activeVideo">
                        <iframe :src="activeVideo" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </template>
                    <template x-if="!activeVideo">
                        <div class="w-full h-full flex flex-col items-center justify-center text-muted space-y-4">
                            <i class="bi bi-play-circle text-[64px] opacity-20"></i>
                            <p class="font-[700] text-[18px]">Select a lesson to start learning</p>
                        </div>
                    </template>
                </div>
                <div>
                    <h1 class="text-[24px] font-[800] text-navy tracking-tight" x-text="activeTitle"></h1>
                    <p class="text-[14px] text-muted font-[500] mt-2 italic">Part of: {{ $course->title }}</p>
                </div>
            </div>

            <!-- Curriculum Sidebar -->
            <div class="w-full lg:w-[360px] shrink-0">
                <div class="bg-white rounded-[12px] border border-border shadow-sm overflow-hidden flex flex-col h-full max-h-[600px]">
                    <div class="p-[24px] border-b border-border">
                        <h3 class="text-[18px] font-[800] text-navy tracking-tight">Course Curriculum</h3>
                        <div class="text-[11px] font-[700] text-primary uppercase tracking-widest mt-1">{{ count($course->lessons) }} Total Lessons</div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-[12px] space-y-[8px]">
                        @foreach($course->lessons as $index => $lesson)
                        <button @click="activeVideo = '{{ $lesson->video_url }}'; activeTitle = '{{ $lesson->title }}'" 
                                :class="activeVideo === '{{ $lesson->video_url }}' ? 'bg-accent border-primary/20' : 'hover:bg-border/10 border-transparent'"
                                class="w-full flex items-center gap-[12px] p-[12px] rounded-[8px] border transition-all text-left group">
                            <div class="w-[36px] h-[36px] rounded-[6px] flex items-center justify-center font-[800] text-[12px] shrink-0 transition-colors"
                                 :class="activeVideo === '{{ $lesson->video_url }}' ? 'bg-primary text-white' : 'bg-border/30 text-muted group-hover:bg-border/50'">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[13px] font-[700] text-navy truncate leading-tight mb-1" :class="activeVideo === '{{ $lesson->video_url }}' ? 'text-primary' : ''">{{ $lesson->title }}</div>
                                <div class="text-[10px] text-muted font-[600] uppercase tracking-wider">Video Lesson</div>
                            </div>
                            <i class="bi bi-play-circle-fill text-[18px] text-border group-hover:text-primary transition-all" :class="activeVideo === '{{ $lesson->video_url }}' ? 'text-primary' : ''"></i>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- MARKETING VIEW (Not Enrolled) -->
    <div class="max-w-6xl mx-auto py-8 px-4 lg:px-0">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <div class="lg:col-span-8 space-y-10">
                <div>
                    <nav class="flex items-center gap-2 text-[11px] font-[700] text-muted uppercase tracking-wider mb-6">
                        <a href="{{ route('courses.index') }}" class="hover:text-primary">All Courses</a>
                        <i class="bi bi-chevron-right text-[8px]"></i>
                        <span class="text-navy">Course Detail</span>
                    </nav>
                    <h1 class="text-[40px] font-[800] text-navy tracking-tight leading-[1.1] mb-6">{{ $course->title }}</h1>
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-[40px] h-[40px] rounded-full bg-accent text-primary flex items-center justify-center font-[800] border-2 border-white shadow-sm hover:scale-105 transition-transform">
                                {{ substr($course->instructor_name, 0, 1) }}
                            </div>
                            <div class="text-[14px]">
                                <div class="text-muted font-[600] text-[11px] uppercase tracking-wider">Instructor</div>
                                <div class="text-navy font-[800]">{{ $course->instructor_name }}</div>
                            </div>
                        </div>
                        <div class="h-[32px] w-[1px] bg-border hidden sm:block"></div>
                        <div class="flex items-center gap-2 text-amber-500 text-[20px]">
                            <i class="bi bi-star-fill"></i>
                            <span class="text-navy font-[800] text-[16px]">4.9 <span class="text-muted font-[600] text-[13px]">(124 Reviews)</span></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-[32px] rounded-[12px] border border-border shadow-sm space-y-6">
                    <h3 class="text-[20px] font-[800] text-navy tracking-tight">What you'll learn</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-[16px]">
                        @foreach(['Foundational Principles', 'Real-world Projects', 'Industry Best Practices', 'Advanced Techniques'] as $benefit)
                        <div class="flex items-center gap-3 text-[14px] text-navy font-[500]">
                            <div class="w-[20px] h-[20px] rounded-full bg-accent text-primary flex items-center justify-center text-[10px] shrink-0"><i class="bi bi-check-lg"></i></div>
                            {{ $benefit }}
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-[20px] font-[800] text-navy tracking-tight">Curriculum Preview</h3>
                    <div class="space-y-[12px]">
                        @foreach($course->lessons->take(3) as $index => $lesson)
                        <div class="flex items-center justify-between p-[20px] bg-border/20 rounded-[8px] border border-transparent hover:border-border transition-all">
                            <div class="flex items-center gap-4">
                                <i class="bi bi-play-circle text-muted text-[18px]"></i>
                                <span class="text-[14px] font-[700] text-navy leading-none">{{ $lesson->title }}</span>
                            </div>
                            <span class="text-[10px] font-[800] text-primary uppercase tracking-widest bg-accent px-2 py-1 rounded">Preview</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sticky Enrollment Card -->
            <div class="lg:col-span-4 sticky top-24">
                <div class="bg-white p-[32px] rounded-[12px] border border-border shadow-md space-y-6 relative overflow-hidden">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600" class="w-full h-[200px] object-cover rounded-[8px] shadow-sm mb-6">
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-[32px] font-[800] text-navy tracking-tight">₹{{ number_format($course->price) }}</span>
                            <span class="text-muted font-[700] line-through text-[16px]">₹{{ number_format($course->price * 1.5) }}</span>
                            <span class="text-primary font-[800] text-[12px] uppercase tracking-widest ml-auto">30% OFF</span>
                        </div>
                        <p class="text-[12px] font-[600] text-muted uppercase tracking-wider mb-6">Lifetime access with one-time payment</p>
                        
                        <a href="{{ route('admissions.create', ['course_id' => $course->id]) }}" class="block w-full py-[16px] bg-primary text-white text-center font-[700] rounded-[8px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/10 uppercase tracking-widest mb-6">
                            Enroll in Course
                        </a>
                        
                        <div class="space-y-4 border-t border-border pt-6">
                            <div class="flex items-center gap-3 text-[14px] font-[700] text-navy">
                                <i class="bi bi-infinite text-primary text-[18px]"></i> Lifetime Access
                            </div>
                            <div class="flex items-center gap-3 text-[14px] font-[700] text-navy">
                                <i class="bi bi-patch-check text-primary text-[18px]"></i> Completion Certificate
                            </div>
                            <div class="flex items-center gap-3 text-[14px] font-[700] text-navy">
                                <i class="bi bi-phone text-primary text-[18px]"></i> Access on all devices
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
