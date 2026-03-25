@extends('layouts.admin')

@section('title', 'Create Premium Course')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4" x-data="{ 
    thumbnailPreview: null,
    files: [],
    handleFileChange(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => this.thumbnailPreview = e.target.result;
            reader.readAsDataURL(file);
        }
    }
}">
    <!-- Top Header -->
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center gap-6">
            <a href="{{ route('trainer.courses.index') }}" class="w-12 h-12 rounded-[12px] bg-white border border-slate-200 flex items-center justify-center text-navy hover:text-primary hover:border-primary/30 transition-all shadow-sm group">
                <i class="bi bi-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-[900] text-navy tracking-tight uppercase leading-none">Course Architect</h1>
                <p class="text-muted text-[13px] font-[600] mt-2 uppercase tracking-[0.2em] opacity-70">Design your master curriculum</p>
            </div>
        </div>
        <div class="hidden md:flex items-center gap-3">
            <span class="px-4 py-2 bg-slate-100 text-slate-500 rounded-[10px] text-[11px] font-[800] uppercase tracking-widest">Draft Mode</span>
        </div>
    </div>

    <form action="{{ route('trainer.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        @if ($errors->any())
            <div class="p-6 bg-red-50 border border-red-100 text-red-600 rounded-[16px] animate-slide-up shadow-sm">
                <div class="flex items-center gap-3 mb-3 pb-3 border-b border-red-100/50">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                    <span class="text-[11px] font-[900] uppercase tracking-[0.2em]">Validation Error</span>
                </div>
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-[13px] font-[700] flex items-center gap-2">
                            <span class="w-1 h-1 bg-red-400 rounded-full"></span>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Left Column: Primary Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Section 1: Core Identity -->
                <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50/50 px-8 py-4 border-b border-slate-100 flex items-center gap-3">
                        <i class="bi bi-info-circle-fill text-primary"></i>
                        <span class="text-[11px] font-[900] text-navy uppercase tracking-widest mt-0.5">Core Identity</span>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-[11px] font-[800] text-navy/60 uppercase tracking-widest mb-3 px-1">Course Title</label>
                            <input type="text" name="title" required placeholder="Enter a compelling title..."
                                   class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[12px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-lg font-[700] text-navy placeholder:text-slate-300">
                        </div>

                        <div>
                            <label class="block text-[11px] font-[800] text-navy/60 uppercase tracking-widest mb-3 px-1">Course Narrative (Description)</label>
                            <textarea name="description" rows="6" required placeholder="Tell the story of this course..."
                                      class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[12px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[600] text-navy/80 leading-relaxed placeholder:text-slate-300 resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-[800] text-navy/60 uppercase tracking-widest mb-3 px-1">Learning Outcomes (One per line)</label>
                            <textarea name="learning_outcomes" rows="4" placeholder="Student will master Laravel basics&#10;Implement complex auth systems..."
                                      class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[12px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy/80 placeholder:text-slate-300 resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Media & Resources -->
                <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50/50 px-8 py-4 border-b border-slate-100 flex items-center gap-3">
                        <i class="bi bi-play-circle-fill text-primary"></i>
                        <span class="text-[11px] font-[900] text-navy uppercase tracking-widest mt-0.5">Media & Initial Resources</span>
                    </div>
                    <div class="p-8 space-y-8">
                        <div>
                            <label class="block text-[11px] font-[800] text-navy/60 uppercase tracking-widest mb-3 px-1">YouTube Intro / Preview Link</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i class="bi bi-youtube text-xl"></i>
                                </span>
                                <input type="url" name="youtube_link" placeholder="https://youtube.com/watch?v=..."
                                       class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-[12px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-[800] text-navy/60 uppercase tracking-widest mb-3 px-1">Course Documentation (PDFs/Guides)</label>
                            <div @click="$refs.documentInput.click()" class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-slate-200 border-dashed rounded-[16px] cursor-pointer hover:border-primary/50 hover:bg-slate-50/20 transition-all group">
                                <div class="space-y-3 text-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-[14px] flex items-center justify-center text-slate-400 mx-auto transition-colors group-hover:bg-primary/10 group-hover:text-primary">
                                        <i class="bi bi-cloud-arrow-up text-3xl"></i>
                                    </div>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <span class="relative rounded-md font-[800] text-primary hover:text-orange-600">
                                            <span>Upload course files</span>
                                            <input x-ref="documentInput" name="documents[]" type="file" class="sr-only" multiple accept=".pdf,.doc,.docx,.zip">
                                        </span>
                                        <p class="pl-1 font-[500] text-slate-500">or drag and drop</p>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest">
                                        PDF, DOCX, ZIP UP TO 10MB EACH
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Visuals -->
            <div class="space-y-8">
                <!-- Course Pricing -->
                <div class="bg-navy p-8 rounded-[16px] shadow-xl shadow-navy/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <i class="bi bi-currency-dollar text-[120px]"></i>
                    </div>
                    <div class="relative z-10 space-y-4">
                        <label class="block text-[11px] font-[900] text-white/50 uppercase tracking-[0.2em]">Course Enrollment Fee</label>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-[900] text-primary">₹</span>
                            <input type="number" name="price" step="0.01" min="0" placeholder="0.00"
                                   class="w-full bg-transparent border-none p-0 text-4xl font-[900] text-white focus:ring-0 placeholder:text-white/20">
                        </div>
                        <p class="text-[11px] text-white/40 font-[600]">Set to 0.00 for a free course</p>
                    </div>
                </div>

                <!-- Thumbnail Management -->
                <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50/50 px-8 py-4 border-b border-slate-100 flex items-center gap-3">
                        <i class="bi bi-image-fill text-primary"></i>
                        <span class="text-[11px] font-[900] text-navy uppercase tracking-widest mt-0.5">Course Visual</span>
                    </div>
                    <div class="p-8 space-y-6">
                        <div @click="$refs.thumbnailInput.click()" class="relative aspect-video rounded-[12px] bg-slate-100 overflow-hidden border-2 border-slate-50 shadow-inner group/preview cursor-pointer">
                            <img :src="thumbnailPreview" x-show="thumbnailPreview" class="w-full h-full object-cover">
                            
                            <div x-show="!thumbnailPreview" class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                <i class="bi bi-image text-5xl mb-3"></i>
                                <span class="text-[11px] font-[800] uppercase tracking-widest">No Preview Selected</span>
                            </div>
                            
                            <div class="absolute inset-0 bg-navy/60 opacity-0 group-hover/preview:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-6 py-2.5 bg-white text-navy font-[800] text-[11px] uppercase tracking-widest rounded-full shadow-lg">Change Cover</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <p class="text-[11px] text-slate-500 font-[600] leading-relaxed italic">
                                "The first thing students see is your cover. Make it high-quality and relevant."
                            </p>
                            <input x-ref="thumbnailInput" type="file" name="thumbnail" accept="image/*" class="hidden" 
                                   @change="handleFileChange($event)">
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="bg-white p-4 rounded-[16px] border border-slate-200 shadow-sm flex flex-col gap-3">
                    <button type="submit" class="w-full py-4 bg-primary text-white font-[900] text-[13px] rounded-[12px] hover:bg-orange-600 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest shadow-xl shadow-orange-500/30">
                        Launch Course <i class="bi bi-rocket-takeoff-fill ml-2"></i>
                    </button>
                    <a href="{{ route('trainer.courses.index') }}" class="w-full py-4 bg-slate-50 text-slate-500 font-[800] text-[13px] rounded-[12px] hover:bg-slate-100 transition-all text-center uppercase tracking-widest">
                        Save to Drafts
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
