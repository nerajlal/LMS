@extends('layouts.admin')

@section('title', isset($course) ? 'Modify Course' : 'Launch Course')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi {{ isset($course) ? 'bi-pencil-square' : 'bi-plus-circle' }} text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase leading-none">
                        {{ isset($course) ? 'Curriculum' : 'Program' }} <span class="text-primary">{{ isset($course) ? 'Modification' : 'Initialization' }}</span>
                    </h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-2">Global catalog metadata management</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-[16px] backdrop-blur-sm">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></div>
                <span class="text-[10px] font-[800] text-slate-300 uppercase tracking-widest">Enterprise Sync Active</span>
            </div>
        </div>
    </div>

    <!-- Form Console -->
    <div class="bg-white rounded-[24px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden relative group">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-50 rounded-full blur-3xl opacity-30 group-hover:scale-150 transition-transform duration-1000"></div>
        
        <form action="{{ isset($course) ? route('admin.courses.update', $course->id) : route('admin.courses.store') }}" 
              method="POST" 
              class="p-8 md:p-12 relative z-10 space-y-10">
            @csrf
            @if(isset($course)) @method('PUT') @endif
            
            <div class="space-y-8">
                <!-- Course Identity -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2 space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Course Title</label>
                        <div class="relative">
                            <i class="bi bi-journal-bookmark absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="title" required 
                                   value="{{ old('title', $course->title ?? '') }}" 
                                   placeholder="e.g. Advanced System Architecture 2024" 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                        @error('title') <p class="mt-2 text-[10px] font-black text-primary uppercase tracking-widest pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Curriculum Abstract</label>
                        <textarea name="description" rows="4" placeholder="Brief outline of course objectives..."
                                  class="w-full p-5 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[14px] font-[700] text-navy outline-none min-h-[120px]">{{ old('description', $course->description ?? '') }}</textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Instructor Assignment</label>
                        <div class="relative">
                            <i class="bi bi-person-badge absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="instructor_name" required 
                                   value="{{ old('instructor_name', $course->instructor_name ?? '') }}" 
                                   placeholder="Assign Instructor" 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                        @error('instructor_name') <p class="mt-2 text-[10px] font-black text-primary uppercase tracking-widest pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Investment Value (INR)</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-[800] text-[14px]">₹</span>
                            <input type="number" name="price" required 
                                   value="{{ old('price', $course->price ?? '') }}" 
                                   placeholder="4999" 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[14px] font-[700] text-navy outline-none font-sans">
                        </div>
                        @error('price') <p class="mt-2 text-[10px] font-black text-primary uppercase tracking-widest pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2 space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Asset Branding (CSS/URL)</label>
                        <div class="relative">
                            <i class="bi bi-palette absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="thumbnail" 
                                   value="{{ old('thumbnail', $course->thumbnail ?? '') }}" 
                                   placeholder="e.g. bg-gradient-to-r from-blue-500 to-indigo-600" 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[12px] font-[800] text-navy uppercase tracking-widest outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Section -->
            <div class="pt-8 border-t border-slate-50 flex flex-col sm:flex-row items-center gap-4">
                <button type="submit" class="w-full sm:flex-1 py-5 bg-navy text-white rounded-[16px] font-[900] text-[12px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/10 active:scale-95 transform flex items-center justify-center gap-3">
                    <i class="bi bi-cloud-arrow-up-fill text-lg"></i>
                    {{ isset($course) ? 'Push Global Updates' : 'Launch New Program' }}
                </button>
                <a href="{{ route('admin.courses.index') }}" class="w-full sm:w-auto px-10 py-5 bg-slate-100 text-slate-500 rounded-[16px] font-[900] text-[12px] uppercase tracking-[0.2em] hover:bg-slate-200 hover:text-navy transition-all text-center">
                    Discard
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
