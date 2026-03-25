@extends('layouts.admin')

@section('title', isset($course) ? 'Modify Course' : 'Create Course')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#e3000f]/10 rounded-full blur-3xl opacity-50"></div>
        
        <div class="p-10 lg:p-14">
            <div class="mb-12 relative flex items-center justify-between">
                <div>
                    <div class="text-[10px] font-black text-[#e3000f] uppercase tracking-[0.2em] mb-2 pl-1">Knowledge Management</div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                        {{ isset($course) ? 'Modify Curriculum' : 'Launch New Program' }}
                    </h1>
                    <p class="text-sm text-slate-500 font-medium italic mt-2">Fill the metadata details below to push updates to the store.</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-16 h-16 bg-[#e3000f]/5 rounded-2xl flex items-center justify-center text-[#e3000f] text-3xl">
                        <i class="bi {{ isset($course) ? 'bi-pencil-square' : 'bi-plus-circle' }}"></i>
                    </div>
                </div>
            </div>

            <form action="{{ isset($course) ? route('admin.courses.update', $course->id) : route('admin.courses.store') }}" 
                  method="POST" 
                  class="space-y-10">
                @csrf
                @if(isset($course)) @method('PUT') @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 pl-1">Course Title</label>
                        <input type="text" name="title" required 
                               value="{{ old('title', $course->title ?? '') }}" 
                               placeholder="e.g. Fullstack Web Development 2024" 
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold shadow-inner">
                        @error('title') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 pl-1">Course Description</label>
                        <textarea name="description" rows="4" 
                                class="w-full px-6 py-4 bg-slate-50 border-none rounded-3xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold shadow-inner">{{ old('description', $course->description ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 pl-1">Instructor Name</label>
                        <input type="text" name="instructor_name" required 
                               value="{{ old('instructor_name', $course->instructor_name ?? '') }}" 
                               placeholder="e.g. Neraj Lal" 
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold shadow-inner">
                        @error('instructor_name') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 pl-1">Course Price (INR)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                            <input type="number" name="price" required 
                                   value="{{ old('price', $course->price ?? '') }}" 
                                   placeholder="4999" 
                                   class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold shadow-inner">
                        </div>
                        @error('price') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 pl-1">Thumbnail Overlay / CSS Color Code</label>
                        <input type="text" name="thumbnail" 
                               value="{{ old('thumbnail', $course->thumbnail ?? '') }}" 
                               placeholder="e.g. bg-blue-500 or image-url" 
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-[10px] font-black uppercase tracking-widest shadow-inner">
                    </div>
                </div>

                <div class="pt-10 flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#e3000f] transition-all transform hover:-translate-y-1 shadow-2xl shadow-slate-900/10">
                        {{ isset($course) ? 'Apply Global Changes' : 'Initialize Curriculum' }}
                    </button>
                    <a href="{{ route('admin.courses.index') }}" class="py-5 px-10 bg-slate-100 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 text-center transition-all">
                        Discard
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
