@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Batch Architect' : 'New Batch Architect')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 md:px-8 py-10" x-data="{ 
    name: '{{ old('name', $branch->name ?? '') }}',
    price: '{{ old('price', $branch->price ?? '0') }}',
    description: '{{ old('description', $branch->description ?? '') }}',
    previewUrl: '{{ $branch->thumbnail ?: '' }}'
}">
    <!-- Cinematic Breadcrumb & Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <div>
            <nav class="flex items-center gap-3 text-[10px] font-[900] text-slate-400 uppercase tracking-[0.3em] mb-4">
                <a href="{{ route('trainer.live-classes.index') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <i class="bi bi-chevron-right text-[8px]"></i>
                <span class="text-navy">Batch Designer</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-[900] text-navy tracking-tight uppercase">
                Batch <span class="text-primary">{{ $isEdit ? 'Architect' : 'Designer' }}</span>
            </h1>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('trainer.live-classes.index') }}" class="px-6 py-4 bg-slate-50 text-slate-500 rounded-[18px] font-[900] text-[12px] uppercase tracking-widest hover:bg-slate-100 transition-all border border-slate-200">
                Discard
            </a>
            <button form="batchForm" type="submit" class="px-8 py-4 bg-navy text-white rounded-[18px] font-[900] text-[12px] uppercase tracking-widest hover:bg-primary transition-all shadow-xl shadow-navy/20 flex items-center gap-3">
                <span>{{ $isEdit ? 'Save Master Blueprint' : 'Launch Batch' }}</span>
                <i class="bi bi-rocket-takeoff-fill"></i>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        <!-- Form Area (8 cols) -->
        <div class="lg:col-span-7 space-y-10">
            <form id="batchForm" 
                  action="{{ $isEdit ? route('trainer.live-classes.branches.update', $branch->id) : route('trainer.live-classes.branches.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-10">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <!-- Core Identity Card -->
                <div class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-8">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-10 h-10 rounded-[12px] bg-primary/10 text-primary flex items-center justify-center">
                            <i class="bi bi-fingerprint text-xl"></i>
                        </div>
                        <h3 class="text-[15px] font-[900] text-navy uppercase tracking-widest">Global Identity</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-3 ml-1">Batch Program Title</label>
                            <input type="text" name="name" x-model="name" required placeholder="e.g. Masterclass: Real-Time BIM Implementation" 
                                   class="w-full px-6 py-4.5 bg-slate-50 border-2 border-transparent rounded-[20px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[16px] font-[700] text-navy placeholder:text-slate-300 italic">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-3 ml-1">Enrollment Price (INR)</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-navy/30 font-black">₹</span>
                                    <input type="number" name="price" x-model="price" required placeholder="0.00" 
                                           class="w-full pl-12 pr-6 py-4.5 bg-slate-50 border-2 border-transparent rounded-[20px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[16px] font-[700] text-navy">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-3 ml-1">Thumbnail Media</label>
                                <label class="block w-full px-6 py-4.5 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[20px] cursor-pointer hover:border-primary/30 hover:bg-slate-100 transition-all text-center">
                                    <input type="file" name="thumbnail" class="hidden" @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            previewUrl = URL.createObjectURL(file);
                                        }
                                    ">
                                    <span class="text-[12px] font-[800] text-slate-400 uppercase tracking-widest flex items-center justify-center gap-3">
                                        <i class="bi bi-cloud-arrow-up-fill text-lg"></i>
                                        <span>Change Banner</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Narrative & Outcomes Card -->
                <div class="bg-white p-8 md:p-10 rounded-[32px] border border-slate-100 shadow-sm space-y-8">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-10 h-10 rounded-[12px] bg-indigo-50 text-indigo-500 flex items-center justify-center">
                            <i class="bi bi-journal-text text-xl"></i>
                        </div>
                        <h3 class="text-[15px] font-[900] text-navy uppercase tracking-widest">Curriculum Narrative</h3>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-3 ml-1">Deep Narrative Description</label>
                            <textarea name="description" x-model="description" required rows="6" placeholder="Articulate the value proposition of this cohort..." 
                                      class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[24px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy placeholder:text-slate-300 resize-none leading-relaxed"></textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-[900] text-navy/40 uppercase tracking-[0.2em] mb-3 ml-1">Learning Outcomes (One per line)</label>
                            <textarea name="learning_outcomes" rows="5" placeholder="Outcome 1&#10;Outcome 2&#10;Outcome 3..." 
                                      class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[24px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy placeholder:text-slate-200 resize-none leading-relaxed italic">{{ old('learning_outcomes', $branch->learning_outcomes ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sticky Preview Sidebar (5 cols) -->
        <div class="lg:col-span-5 sticky top-10 space-y-8">
            <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm overflow-hidden text-center relative">
                <div class="absolute top-4 right-6">
                    <span class="text-[9px] font-black text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-widest border border-emerald-100">Live Preview</span>
                </div>
                
                <h3 class="text-[15px] font-[900] text-navy uppercase tracking-widest mb-10 text-left border-b border-slate-50 pb-4">Student View Mockup</h3>

                <!-- Sample Batch Card -->
                <div class="w-full max-w-[340px] mx-auto bg-white rounded-[28px] border border-slate-100 shadow-2xl overflow-hidden flex flex-col group text-left">
                    <div class="relative h-44 overflow-hidden">
                        <img :src="previewUrl || 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=600'" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/90 to-transparent"></div>
                        <div class="absolute bottom-4 left-6 pr-6">
                            <span class="text-[9px] font-black text-primary uppercase tracking-[0.2em] block mb-1">Live Program</span>
                            <h4 class="text-[16px] font-[900] text-white leading-tight" x-text="name || 'Independent Live Cohort'"></h4>
                        </div>
                    </div>
                    <div class="p-6 pb-8 space-y-6">
                        <p class="text-slate-500 text-[12px] font-[600] line-clamp-3 italic opacity-80 leading-relaxed" x-text="description || 'Master professional skills with expert trainers in our interactive live sessions.'"></p>
                        
                        <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                            <div>
                                <div class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1 truncate">With {{ auth()->user()->name }}</div>
                                <div class="text-lg font-black text-navy" x-text="'₹' + (parseInt(price).toLocaleString() || '0')"></div>
                            </div>
                            <div class="px-5 py-2.5 bg-navy text-white text-[10px] font-black uppercase tracking-widest rounded-[12px]">
                                Enroll
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 p-6 bg-slate-50 rounded-[20px] border border-slate-100">
                    <p class="text-[11px] text-slate-400 font-bold leading-relaxed italic">
                        <i class="bi bi-info-circle text-primary text-lg block mb-2"></i>
                        The layout above reflects how this batch will appear in the "Available Batches" section for every student across the platform.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endsection
