@extends('layouts.admin')

@section('title', 'Manage: ' . $course->title)

@section('content')
<div x-data="{ 
    activeTab: 'lessons',
    showVideoModal: false,
    currentVideoUrl: '',
    currentVideoTitle: '',
    playVideo(url, title) {
        let videoId = '';
        const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^&?\/\s]{11})/;
        const match = url.match(regex);
        if (match && match[1]) {
            videoId = match[1];
            this.currentVideoUrl = 'https://www.youtube.com/embed/' + videoId + '?rel=0&modestbranding=1&iv_load_policy=3&showinfo=0&autoplay=1';
            this.currentVideoTitle = title;
            this.showVideoModal = true;
        } else {
            alert('Invalid YouTube URL');
        }
    }
}" class="space-y-10">
    <!-- Header/Hero Section -->
    <div class="relative bg-navy rounded-[16px] p-8 md:p-12 overflow-hidden shadow-xl shadow-navy/20">
        <!-- Abstract Background Ornaments -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div class="space-y-4 max-w-3xl">
                <div class="flex items-center gap-3">
                    <span class="px-4 py-1.5 bg-primary text-white text-[10px] font-[900] uppercase tracking-[0.2em] rounded-[8px] shadow-lg shadow-orange-500/20">
                        Master Curriculum
                    </span>
                    @if($course->price > 0)
                        <span class="px-4 py-1.5 bg-white/10 text-white text-[10px] font-[900] uppercase tracking-[0.2em] rounded-[8px] border border-white/20">
                            ₹{{ number_format($course->price, 2) }}
                        </span>
                    @else
                        <span class="px-4 py-1.5 bg-emerald-500/20 text-emerald-400 text-[10px] font-[900] uppercase tracking-[0.2em] rounded-[8px] border border-emerald-500/30">
                            Free Course
                        </span>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl font-[900] text-white tracking-tight leading-tight uppercase">{{ $course->title }}</h1>
                <p class="text-white/60 text-lg font-[500] leading-relaxed line-clamp-2 max-w-2xl">{{ $course->description }}</p>
                
                <div class="flex flex-wrap items-center gap-6 pt-2">
                    <div class="flex items-center gap-2.5 text-white/80 text-[13px] font-[700] uppercase tracking-wider">
                        <i class="bi bi-play-circle-fill text-primary text-xl"></i>
                        <span>{{ count($course->lessons) }} Lessons</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-white/80 text-[13px] font-[700] uppercase tracking-wider border-l border-white/10 pl-6">
                        <i class="bi bi-files text-primary text-xl"></i>
                        <span>{{ count($course->studyMaterials) }} Materials</span>
                    </div>
                    <!-- Delete Course Button -->
                    <div class="flex items-center gap-2.5 border-l border-white/10 pl-6">
                        <form action="{{ route('trainer.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course and all its content? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all text-[11px] font-[900] uppercase tracking-widest rounded-[8px] border border-red-500/30">
                                <i class="bi bi-trash3-fill"></i> Delete Course
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Header Quick Actions (Tabs) -->
            <div class="flex bg-white/10 backdrop-blur-md p-1.5 rounded-[16px] border border-white/10 self-start">
                <button @click="activeTab = 'lessons'" 
                        :class="activeTab === 'lessons' ? 'bg-primary text-white shadow-xl shadow-orange-500/30' : 'text-white/60 hover:text-white'"
                        class="px-8 py-3.5 rounded-[12px] font-[800] uppercase tracking-widest text-[11px] transition-all flex items-center gap-3">
                    <i class="bi bi-play-btn-fill"></i> Lessons
                </button>
                <button @click="activeTab = 'materials'" 
                        :class="activeTab === 'materials' ? 'bg-primary text-white shadow-xl shadow-orange-500/30' : 'text-white/60 hover:text-white'"
                        class="px-8 py-3.5 rounded-[12px] font-[800] uppercase tracking-widest text-[11px] transition-all flex items-center gap-3">
                    <i class="bi bi-file-earmark-text-fill"></i> Resources
                </button>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-red-50 border border-red-100 text-red-600 rounded-[12px] text-sm font-[800] uppercase tracking-wider">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- YouTube Intro Banner (New) -->
            @if($course->youtube_link)
            <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-slate-50/50 px-8 py-5 border-b border-slate-100 flex items-center gap-3 font-[900] text-navy uppercase text-[11px] tracking-widest">
                    <i class="bi bi-youtube text-red-600"></i>
                    Course Introduction Video
                </div>
                    <div class="aspect-video rounded-[12px] overflow-hidden shadow-inner">
                        @php
                            $youtubeId = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $course->youtube_link, $matches)) {
                                $youtubeId = $matches[1];
                            }
                        @endphp
                        @if($youtubeId)
                            <iframe class="w-full h-full" 
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}" 
                                    frameborder="0" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-300">
                                <p class="text-[11px] font-[800] uppercase tracking-widest">Invalid YouTube Link</p>
                            </div>
                        @endif
                    </div>
            </div>
            @endif

            <!-- Learning Outcomes Widget (New) -->
            @if($course->learning_outcomes)
            <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-slate-50/50 px-8 py-5 border-b border-slate-100 flex items-center gap-3 font-[900] text-navy uppercase text-[11px] tracking-widest">
                    <i class="bi bi-patch-check-fill text-primary"></i>
                    What students will master
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(explode("\n", $course->learning_outcomes) as $outcome)
                            @if(trim($outcome))
                            <div class="flex items-start gap-4 p-4 rounded-[12px] bg-slate-50 border border-transparent hover:border-primary/20 transition-all">
                                <i class="bi bi-check-circle-fill text-primary mt-0.5"></i>
                                <span class="text-[14px] font-[600] text-navy/80 leading-snug">{{ trim($outcome) }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Tab Content: Lessons -->
            <div x-show="activeTab === 'lessons'" x-transition class="space-y-6">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Recorded Curriculum</h3>
                    <div class="px-4 py-1.5 bg-slate-100 text-slate-500 rounded-full text-[10px] font-[900] uppercase tracking-widest">Live Flow</div>
                </div>
                <div class="grid gap-4">
                    @forelse($course->lessons as $index => $lesson)
                     <div class="bg-white p-5 rounded-[16px] border border-slate-100 shadow-sm flex items-center gap-6 group hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 rounded-[14px] bg-slate-50 text-navy flex items-center justify-center font-[900] text-base shrink-0 group-hover:bg-primary group-hover:text-white transition-all">
                            {{ sprintf('%02d', $index + 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[15px] font-[800] text-navy truncate leading-none mb-2">{{ $lesson->title }}</div>
                            <div class="text-[10px] text-muted font-[700] uppercase tracking-widest flex items-center gap-2">
                                <i class="bi bi-play-circle text-primary"></i> Video Lesson &bull; Dynamic Order
                            </div>
                        </div>
                        <button @click="playVideo('{{ $lesson->video_url }}', '{{ $lesson->title }}')" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 hover:text-primary transition-colors">
                            <i class="bi bi-play-fill text-2xl"></i>
                        </button>
                    </div>
                    @empty
                    <div class="bg-white py-20 rounded-[16px] border border-dashed border-slate-200 text-center">
                        <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                            <i class="bi bi-camera-video"></i>
                        </div>
                        <p class="text-slate-400 font-[800] text-xs uppercase tracking-widest">No video lessons recorded yet</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab Content: Materials -->
            <div x-show="activeTab === 'materials'" x-transition x-cloak class="space-y-6">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Course Resources</h3>
                    <div class="px-4 py-1.5 bg-slate-100 text-slate-500 rounded-full text-[10px] font-[900] uppercase tracking-widest">Downloadable</div>
                </div>
                <div class="grid gap-4">
                    @forelse($course->studyMaterials as $mat)
                    <div class="bg-white p-5 rounded-[16px] border border-slate-100 shadow-sm flex items-center gap-6 group hover:border-primary/30 transition-all">
                        <div class="w-12 h-12 rounded-[14px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[15px] font-[800] text-navy truncate leading-none mb-2">{{ $mat->title }}</div>
                            <div class="text-[10px] text-muted font-[700] uppercase tracking-widest">
                                {{ strtoupper($mat->file_type) }} &bull; {{ is_numeric($mat->file_size) ? number_format($mat->file_size / (1024 * 1024), 2) . ' MB' : $mat->file_size }}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ $mat->file_path }}" target="_blank" class="p-3 rounded-[12px] bg-slate-50 text-slate-400 hover:bg-navy hover:text-white transition-all">
                                <i class="bi bi-download text-lg"></i>
                            </a>
                            <form action="{{ route('trainer.courses.materials.destroy', [$course->id, $mat->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this resource?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 rounded-[12px] bg-red-50 text-red-400 hover:bg-red-500 hover:text-white transition-all">
                                    <i class="bi bi-trash3 text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white py-20 rounded-[16px] border border-dashed border-slate-200 text-center">
                        <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <p class="text-slate-400 font-[800] text-xs uppercase tracking-widest">No materials uploaded yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sticky Sidebar Forms -->
        <div class="space-y-8 sticky top-24">
            <!-- Add Lesson Widget -->
             <div x-show="activeTab === 'lessons'" x-transition class="bg-white p-8 rounded-[16px] border border-slate-200 shadow-xl shadow-slate-200/20 space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-50">
                    <div class="w-10 h-10 bg-orange-50 rounded-[10px] flex items-center justify-center text-primary">
                        <i class="bi bi-plus-lg text-lg"></i>
                    </div>
                    <h3 class="text-[11px] font-[900] text-navy uppercase tracking-[0.2em] mt-1">Append Lesson</h3>
                </div>
                <form action="{{ route('trainer.courses.lessons.store', $course->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-[800] text-navy/40 uppercase tracking-widest mb-2 px-1">Lesson Title</label>
                        <input type="text" name="title" required placeholder="Foundations & Setup" 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-sm font-[700] text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-[800] text-navy/40 uppercase tracking-widest mb-2 px-1">YouTube Link</label>
                        <input type="url" name="video_url" required placeholder="https://youtube.com/..." 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-sm font-[700] text-navy">
                    </div>
                    <button type="submit" class="w-full py-4 bg-navy text-white rounded-[12px] font-[800] text-[11px] uppercase tracking-widest hover:bg-primary transition-all shadow-xl shadow-navy/10">
                        Add to Curriculum
                    </button>
                </form>
            </div>

            <!-- Add Material Widget -->
            <div x-show="activeTab === 'materials'" x-transition x-cloak class="bg-white p-8 rounded-[16px] border border-slate-200 shadow-xl shadow-slate-200/20 space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-50">
                    <div class="w-10 h-10 bg-emerald-50 rounded-[10px] flex items-center justify-center text-emerald-600">
                        <i class="bi bi-cloud-arrow-up text-lg"></i>
                    </div>
                    <h3 class="text-[11px] font-[900] text-navy uppercase tracking-[0.2em] mt-1">Upload Material</h3>
                </div>
                <form action="{{ route('trainer.courses.materials.store', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-[800] text-navy/40 uppercase tracking-widest mb-2 px-1">Resource Name</label>
                        <input type="text" name="title" required placeholder="Course Handout PDF" 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-emerald-500/20 focus:bg-white transition-all text-sm font-[700] text-navy">
                    </div>
                    <div>
                        <label class="block text-[10px] font-[800] text-navy/40 uppercase tracking-widest mb-2 px-1">Select File</label>
                        <div class="relative group">
                            <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="px-4 py-10 bg-slate-50 border-2 border-dashed border-slate-100 rounded-[12px] text-center group-hover:border-emerald-200 transition-colors">
                                <i class="bi bi-file-earmark-plus text-3xl text-slate-200"></i>
                                <div class="text-[10px] font-[800] text-slate-300 uppercase tracking-widest mt-2">Browse Files</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-4 bg-navy text-white rounded-[12px] font-[800] text-[11px] uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-navy/10">
                        Secure Upload
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Video Playback Modal -->
    <div x-show="showVideoModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[2000] flex items-center justify-center p-4 sm:p-6 bg-navy/95 backdrop-blur-sm"
         x-cloak>
        
        <div @click.away="showVideoModal = false; currentVideoUrl = ''" 
             class="relative w-full max-w-5xl bg-black rounded-[24px] overflow-hidden shadow-2xl border border-white/10 animate-scale-up">
            
            <!-- Modal Header -->
            <div class="absolute top-0 left-0 right-0 p-6 flex items-center justify-between z-10 bg-gradient-to-b from-black/80 to-transparent">
                <h3 class="text-white font-[800] text-[15px] uppercase tracking-widest truncate max-w-[80%]" x-text="currentVideoTitle"></h3>
                <button @click="showVideoModal = false; currentVideoUrl = ''" class="w-10 h-10 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-primary transition-all group">
                    <i class="bi bi-x-lg group-hover:rotate-90 transition-transform"></i>
                </button>
            </div>

            <!-- Video Container with Masking to Hide Branding/Sharing -->
            <div class="relative w-full overflow-hidden bg-black" style="aspect-ratio: 16/9;">
                <template x-if="showVideoModal">
                    <div class="absolute inset-0 scale-[1.1] origin-center">
                        <iframe :src="currentVideoUrl" 
                                class="w-full h-full" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen></iframe>
                    </div>
                </template>
                <!-- Protective Layer (Optional: prevents some clicks but might break controls) -->
                <div class="absolute top-0 left-0 right-0 h-16 bg-gradient-to-b from-black/20 to-transparent pointer-events-none"></div>
            </div>

            <!-- Modal Footer (Confidentiality Notice) -->
            <div class="p-4 bg-navy/50 flex items-center justify-center gap-3">
                <i class="bi bi-shield-lock-fill text-primary"></i>
                <span class="text-[10px] font-[900] text-white/40 uppercase tracking-[0.3em]">Confidential Curriculum Content • Proprietary to The Ace India</span>
            </div>
        </div>
    </div>
</div>
@endsection
