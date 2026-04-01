@extends('layouts.app')

@section('title', $course->title . ' - The Ace India')

@section('content')
<div x-data="{ 
    isEnrolled: {{ $isEnrolled ? 'true' : 'false' }},
    activeVideo: '',
    activeTitle: '{{ count($course->lessons) > 0 ? $course->lessons[0]->title : "Select a lesson" }}',
    activeLessonId: '{{ count($course->lessons) > 0 ? $course->lessons[0]->id : "" }}',
    completedLessons: @js($completedLessons),
    progress: {{ $initialProgress }},
    hasFeedback: {{ $hasFeedback ? 'true' : 'false' }},
    showFeedbackModal: false,
    getEmbedUrl(url) {
        if (!url) return '';
        let videoId = '';
        const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/\s]{11})/;
        const match = url.match(regex);
        if (match && match[1]) {
            return 'https://www.youtube.com/embed/' + match[1] + '?rel=0&modestbranding=1&iv_load_policy=3&showinfo=0&autoplay=1';
        }
        return url;
    },
    markAsCompleted() {
        if(!this.activeLessonId) return;
        
        fetch('{{ route('courses.progress.update', $course->id) }}', { 
            method: 'POST', 
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ lesson_id: this.activeLessonId })
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                this.completedLessons = data.completed_lessons;
                this.progress = data.new_progress;
                
                if (this.progress === 100 && !this.hasFeedback) {
                    this.showFeedbackModal = true;
                }
            }
        });
    },
    isLessonCompleted(id) {
        return this.completedLessons.includes(parseInt(id));
    },
    init() {
        @if(count($course->lessons) > 0)
            this.activeVideo = this.getEmbedUrl('{{ $course->lessons[0]->video_url }}');
        @endif
        
        if (this.progress === 100 && !this.hasFeedback) {
            setTimeout(() => { this.showFeedbackModal = true; }, 1000);
        }
    }
}">
    
    @if($isEnrolled)
    <!-- LEARNING VIEW (Enrolled) -->
    <div class="space-y-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Video Player Area -->
            <div class="lg:col-span-2 flex-1 space-y-6">
                <div class="aspect-video bg-black rounded-[12px] overflow-hidden shadow-lg relative border-border">
                    <template x-if="activeVideo">
                        <div class="absolute inset-0 scale-[1.1] origin-center">
                            <iframe :src="activeVideo" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </template>
                    <template x-if="!activeVideo">
                        <div class="w-full h-full flex flex-col items-center justify-center text-muted space-y-4">
                            <i class="bi bi-play-circle text-[64px] opacity-20"></i>
                            <p class="font-[700] text-[18px]">Select a lesson to start learning</p>
                        </div>
                    </template>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-[20px] md:text-[24px] font-[800] text-navy tracking-tight" x-text="activeTitle"></h1>
                        <p class="text-[13px] md:text-[14px] text-muted font-[500] mt-1.5 md:mt-2 italic">Part of: {{ $course->title }}</p>
                    </div>
                    <button @click="markAsCompleted()" 
                            :disabled="isLessonCompleted(activeLessonId)"
                            :class="isLessonCompleted(activeLessonId) ? 'bg-emerald-600 cursor-default' : 'bg-primary hover:bg-orange-600'"
                            class="w-full sm:w-auto px-4 md:px-6 py-2 md:py-2.5 text-white text-[11px] md:text-[12px] font-[800] uppercase tracking-widest rounded-[8px] transition-all shadow-lg flex items-center justify-center gap-2">
                        <i :class="isLessonCompleted(activeLessonId) ? 'bi bi-check-all text-lg' : 'bi bi-check-circle-fill'"></i>
                        <span x-text="isLessonCompleted(activeLessonId) ? 'Completed' : 'Mark as Completed'"></span>
                    </button>
                </div>

                <!-- FINAL EXAM SECTION -->
                <template x-if="completedLessons.length === {{ count($course->lessons) ?: -1 }}">
                    <div class="mt-10 p-8 rounded-[24px] bg-navy text-white shadow-2xl relative overflow-hidden group border border-white/10">
                        <div class="absolute top-[-20px] right-[-20px] w-48 h-48 bg-primary/20 rounded-full blur-[60px] group-hover:scale-125 transition-transform duration-700"></div>
                        
                        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                            <div class="flex items-center gap-6">
                                <div class="w-16 h-16 rounded-[20px] bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-xl">
                                    <i class="bi bi-mortarboard text-3xl text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl md:text-2xl font-[900] uppercase tracking-tight">Final <span class="text-primary">Examination</span></h3>
                                    <p class="text-slate-400 text-[12px] md:text-[13px] font-[600] uppercase tracking-widest mt-1">Unlock your institutional certification.</p>
                                </div>
                            </div>
                            
                            <a href="{{ route('courses.exam.show', $course->id) }}" class="px-10 py-5 bg-white text-navy font-[900] text-[13px] uppercase tracking-[0.2em] rounded-[18px] hover:bg-primary hover:text-white transition-all shadow-xl active:scale-[0.98] whitespace-nowrap">
                                Take Final Exam <i class="bi bi-arrow-right ml-2 text-lg"></i>
                            </a>
                        </div>
                    </div>
                </template>

                @if($course->description)
                <div class="text-[14px] text-muted font-[500] leading-relaxed mt-4 bg-border/20 p-4 rounded-[8px] border-l-4 border-primary/20">
                    {!! nl2br(e($course->description)) !!}
                </div>
                @endif

                <!-- Learning Outcomes (Enrolled View) -->
                <div class="bg-white p-[24px] rounded-[12px] border border-border shadow-sm space-y-6 mt-8">
                    <h3 class="text-[18px] font-[800] text-navy tracking-tight uppercase tracking-[0.1em]">What you'll learn</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                        @if($course->learning_outcomes)
                            @foreach(explode("\n", $course->learning_outcomes) as $outcome)
                                @if(trim($outcome))
                                <div class="flex items-start gap-3 text-[13px] text-navy font-[600] leading-relaxed">
                                    <div class="w-[20px] h-[20px] rounded-full bg-accent text-primary flex items-center justify-center text-[10px] shrink-0 mt-0.5"><i class="bi bi-check-lg"></i></div>
                                    <span>{{ trim($outcome) }}</span>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Study Materials (Enrolled View) -->
                @if($course->studyMaterials->count() > 0)
                <div class="space-y-6 mt-10">
                    <h3 class="text-[18px] font-[800] text-navy tracking-tight uppercase tracking-[0.1em]">Study Materials</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($course->studyMaterials as $material)
                        <div class="flex items-center justify-between p-4 bg-white rounded-[12px] border border-border hover:border-primary/20 hover:shadow-md transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-accent text-primary rounded-[8px] flex items-center justify-center text-lg">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </div>
                                <div>
                                    <div class="text-[13px] font-[700] text-navy line-clamp-1">{{ $material->title }}</div>
                                    <div class="text-[10px] text-muted font-[800] uppercase tracking-widest">{{ $material->file_type }} • {{ is_numeric($material->file_size) ? round($material->file_size / 1024 / 1024, 2) . ' MB' : $material->file_size }}</div>
                                </div>
                            </div>
                            <a href="{{ $material->file_path }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-50 text-navy flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-sm">
                                <i class="bi bi-download text-sm"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Curriculum Sidebar -->
            <div class="w-full lg:w-[360px] shrink-0">
                <div class="bg-white rounded-[12px] border border-border shadow-sm overflow-hidden flex flex-col h-full max-h-[600px]">
                    <div class="p-[24px] border-b border-border flex items-center justify-between">
                        <div>
                            <h3 class="text-[18px] font-[800] text-navy tracking-tight">Curriculum</h3>
                            <div class="text-[11px] font-[700] text-primary uppercase tracking-widest mt-1">{{ count($course->lessons) }} Total Lessons</div>
                        </div>
                        <div class="text-right">
                             <div class="text-[20px] font-[900] text-navy tracking-tighter" x-text="Math.round((completedLessons.length / {{ count($course->lessons) ?: 1 }}) * 100) + '%'"></div>
                             <div class="text-[9px] font-[800] text-muted uppercase tracking-[0.15em]">Mastery</div>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-[12px] space-y-[8px]">
                        @foreach($course->lessons as $index => $lesson)
                        <button @click="activeVideo = getEmbedUrl('{{ $lesson->video_url }}'); activeTitle = '{{ $lesson->title }}'; activeLessonId = '{{ $lesson->id }}'" 
                                :class="activeLessonId == '{{ $lesson->id }}' ? 'bg-accent border-primary/20' : 'hover:bg-border/10 border-transparent'"
                                class="w-full flex items-center gap-[12px] p-[12px] rounded-[8px] border transition-all text-left group">
                            <div class="w-[36px] h-[36px] rounded-[6px] flex items-center justify-center font-[800] text-[12px] shrink-0 transition-all relative"
                                 :class="activeLessonId == '{{ $lesson->id }}' ? 'bg-primary text-white shadow-lg shadow-orange-500/10' : (isLessonCompleted('{{ $lesson->id }}') ? 'bg-emerald-50 text-emerald-600' : 'bg-border/30 text-muted group-hover:bg-border/50')">
                                <span x-show="!isLessonCompleted('{{ $lesson->id }}')">{{ $index + 1 }}</span>
                                <i x-show="isLessonCompleted('{{ $lesson->id }}')" class="bi bi-check-lg text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[13px] font-[700] text-navy truncate leading-tight mb-1" :class="activeLessonId == '{{ $lesson->id }}' ? 'text-primary' : (isLessonCompleted('{{ $lesson->id }}') ? 'text-emerald-700' : '')">{{ $lesson->title }}</div>
                                <div class="text-[10px] text-muted font-[600] uppercase tracking-wider">Video Lesson</div>
                            </div>
                            <i class="bi bi-play-circle-fill text-[18px] text-border group-hover:text-primary transition-all" :class="activeLessonId == '{{ $lesson->id }}' ? 'text-primary' : (isLessonCompleted('{{ $lesson->id }}') ? 'text-emerald-500 opacity-50' : '')"></i>
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
                    @if($course->youtube_link)
                    @php
                        $videoId = '';
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $course->youtube_link, $match)) {
                            $videoId = $match[1];
                        }
                    @endphp
                    @if($videoId)
                    <div class="mb-10 rounded-[24px] overflow-hidden shadow-2xl border-4 border-white bg-black aspect-video relative group/trailer">
                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="absolute top-4 left-4 pointer-events-none">
                            <span class="px-3 py-1.5 bg-primary text-white text-[10px] font-[900] uppercase tracking-widest rounded-full shadow-lg flex items-center gap-2">
                                <i class="bi bi-play-fill text-[14px]"></i> Course Trailer
                            </span>
                        </div>
                    </div>
                    @endif
                    @endif

                    <h1 class="text-[28px] md:text-[40px] font-[800] text-navy tracking-tight leading-[1.2] md:leading-[1.1] mb-6">{{ $course->title }}</h1>
                    
                    @if($course->description)
                    <div class="text-[16px] text-muted font-[500] leading-relaxed mb-6 max-w-3xl">
                        {!! nl2br(e($course->description)) !!}
                    </div>
                    @endif

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
                            <span class="text-navy font-[800] text-[16px]">{{ number_format(4.5 + (($course->id % 5) / 10), 1) }} <span class="text-muted font-[600] text-[13px]">({{ 50 + ($course->id * 7 % 200) }} Reviews)</span></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 md:p-8 rounded-[12px] border border-border shadow-sm space-y-6">
                    <h3 class="text-[20px] font-[800] text-navy tracking-tight uppercase tracking-[0.1em]">What you'll learn</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                        @if($course->learning_outcomes)
                            @foreach(explode("\n", $course->learning_outcomes) as $outcome)
                                @if(trim($outcome))
                                <div class="flex items-start gap-3 text-[14px] text-navy font-[600] leading-relaxed">
                                    <div class="w-[22px] h-[22px] rounded-full bg-accent text-primary flex items-center justify-center text-[11px] shrink-0 mt-0.5"><i class="bi bi-check-lg"></i></div>
                                    <span>{{ trim($outcome) }}</span>
                                </div>
                                @endif
                            @endforeach
                        @else
                            @foreach(['Master foundational principles', 'Work on real-world projects', 'Learn industry best practices', 'Gain advanced technical skills'] as $benefit)
                            <div class="flex items-start gap-3 text-[14px] text-navy font-[600] leading-relaxed">
                                <div class="w-[22px] h-[22px] rounded-full bg-accent text-primary flex items-center justify-center text-[11px] shrink-0 mt-0.5"><i class="bi bi-check-lg"></i></div>
                                <span>{{ $benefit }}</span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Study Materials for Marketing View -->
                @if($course->studyMaterials->count() > 0)
                <div class="space-y-6">
                    <h3 class="text-[20px] font-[800] text-navy tracking-tight uppercase tracking-[0.1em]">Course Resources</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($course->studyMaterials as $material)
                        <div class="flex items-center justify-between p-5 bg-white rounded-[12px] border border-border hover:border-primary/20 hover:shadow-md transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-accent text-primary rounded-[8px] flex items-center justify-center text-lg">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </div>
                                <div>
                                    <div class="text-[14px] font-[700] text-navy line-clamp-1">{{ $material->title }}</div>
                                    <div class="text-[10px] text-muted font-[800] uppercase tracking-widest">{{ $material->file_type }} • {{ is_numeric($material->file_size) ? round($material->file_size / 1024 / 1024, 2) . ' MB' : $material->file_size }}</div>
                                </div>
                            </div>
                            <a href="{{ $material->file_path }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-50 text-navy flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-sm">
                                <i class="bi bi-download text-sm"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="space-y-6">
                    <h3 class="text-[20px] font-[800] text-navy tracking-tight uppercase tracking-[0.1em]">Curriculum Preview</h3>
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
                <div class="bg-white p-6 md:p-8 rounded-[16px] border border-border shadow-xl shadow-navy/5 space-y-6 relative overflow-hidden">
                    <div class="relative">
                        <img src="{{ $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600' }}" 
                             class="w-full h-[200px] object-cover rounded-[12px] shadow-sm mb-6 border border-border">
                        
                        <div class="flex items-baseline gap-2 mb-2">
                            <span class="text-[36px] font-[900] text-navy tracking-tighter">₹{{ number_format($course->price) }}</span>
                            @if($course->price > 0)
                            <span class="text-muted font-[700] line-through text-[16px]">₹{{ number_format($course->price * 1.4) }}</span>
                            <span class="px-2 py-0.5 bg-red-50 text-red-500 font-[800] text-[10px] uppercase tracking-widest rounded-[4px] ml-auto">Limited Offer</span>
                            @else
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 font-[800] text-[11px] uppercase tracking-widest rounded-full ml-auto border border-emerald-100 italic">Free Enrollment</span>
                            @endif
                        </div>
                        <p class="text-[11px] font-[800] text-muted uppercase tracking-[0.15em] mb-6 flex items-center gap-2">
                            <i class="bi bi-clock text-primary"></i> Last updated {{ $course->updated_at->format('M Y') }}
                        </p>
                        
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

    <!-- FEEDBACK POPUP MODAL -->
    <template x-if="showFeedbackModal">
        <div class="fixed inset-0 z-[2000] flex items-center justify-center p-4 md:p-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 pb-12" x-transition:enter-end="opacity-100 pb-0">
            <!-- Glassmorphism Backdrop -->
            <div class="absolute inset-0 bg-navy/40 backdrop-blur-xl"></div>
            
            <!-- Modal Content -->
            <div class="relative bg-white w-full max-w-lg rounded-[32px] overflow-hidden shadow-2xl shadow-navy/20 border border-white/20 animate-in zoom-in duration-500">

                <div class="relative">
                    <div class="h-32 bg-navy relative overflow-hidden">
                        <div class="absolute top-[-20px] right-[-20px] w-32 h-32 bg-primary/20 rounded-full blur-[40px]"></div>
                        <div class="absolute bottom-[-10px] left-10 w-20 h-20 bg-emerald-500/10 rounded-full blur-[30px]"></div>
                        <div class="absolute inset-0 flex items-center justify-center pt-8">
                            <div class="w-20 h-20 bg-white rounded-[24px] shadow-2xl flex items-center justify-center border-4 border-white/50">
                                <i class="bi bi-patch-check-fill text-4xl text-emerald-500"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 pt-12 text-center">
                        <h3 class="text-2xl font-[900] text-navy uppercase tracking-tight mb-2">Curriculum <span class="text-primary">Mastered!</span></h3>
                        <p class="text-slate-500 font-[500] text-[14px] mb-8 leading-relaxed">Congratulations, you've completed 100% of the course. Before you unlock the exam, please share your experience.</p>
                        
                        <form action="{{ route('feedback.store', $course->id) }}" method="POST" x-data="{ currentRating: 0 }" class="space-y-6">
                            @csrf
                            <input type="hidden" name="rating" :value="currentRating" required>
                            
                            <!-- Star Rating Interactor -->
                            <div class="flex items-center justify-center gap-4">
                                <template x-for="i in 5">
                                    <button type="button" @click="currentRating = i" 
                                            class="text-4xl transition-all duration-300 transform hover:scale-125" 
                                            :class="currentRating >= i ? 'text-primary scale-110 drop-shadow-lg' : 'text-slate-100'">
                                        <i :class="currentRating >= i ? 'bi bi-star-fill' : 'bi bi-star'"></i>
                                    </button>
                                </template>
                            </div>

                            <div class="relative">
                                <textarea name="comment" placeholder="Describe your learning journey..." 
                                          class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[20px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy placeholder:text-slate-300 resize-none" rows="3"></textarea>
                            </div>

                            <button type="submit" :disabled="currentRating === 0" 
                                    class="w-full py-5 bg-navy text-white rounded-[20px] font-[900] text-[13px] uppercase tracking-[0.2em] shadow-xl shadow-navy/20 hover:bg-primary transition-all disabled:opacity-50 disabled:cursor-not-allowed group">
                                <span class="flex items-center justify-center gap-2">
                                    Submit Appreciation
                                    <i class="bi bi-arrow-right-short text-xl group-hover:translate-x-1 transition-transform"></i>
                                </span>
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection
