@extends('layouts.admin')

@section('title', isset($course) ? 'Modify Course' : 'Create Course')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-[12px] border border-border shadow-md relative overflow-hidden">
        <div class="p-8 lg:p-12">
            <div class="mb-10 relative flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-[700] text-primary uppercase tracking-widest mb-2 pl-1">Knowledge Management</div>
                    <h1 class="text-[32px] font-[800] text-navy tracking-tight">
                        {{ isset($course) ? 'Modify Curriculum' : 'Launch New Program' }}
                    </h1>
                    <p class="text-[14px] text-muted font-[500] mt-2 italic">Fill the metadata details below to push updates to the store.</p>
                </div>
                <div class="hidden sm:block">
                    <div class="w-16 h-16 bg-accent rounded-[12px] flex items-center justify-center text-primary text-3xl">
                        <i class="bi {{ isset($course) ? 'bi-pencil-square' : 'bi-plus-circle' }}"></i>
                    </div>
                </div>
            </div>

            <form action="{{ isset($course) ? route('admin.courses.update', $course->id) : route('admin.courses.store') }}" 
                  method="POST" 
                  class="space-y-8">
                @csrf
                @if(isset($course)) @method('PUT') @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-[32px]">
                    <div class="md:col-span-2">
                        <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-3 pl-1">Course Title</label>
                        <input type="text" name="title" required 
                               value="{{ old('title', $course->title ?? '') }}" 
                               placeholder="e.g. Fullstack Web Development 2024" 
                               class="w-full px-5 py-3 bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                        @error('title') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-3 pl-1">Course Description</label>
                        <textarea name="description" rows="4" 
                                class="w-full px-5 py-3 bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">{{ old('description', $course->description ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-3 pl-1">Instructor Name</label>
                        <input type="text" name="instructor_name" required 
                               value="{{ old('instructor_name', $course->instructor_name ?? '') }}" 
                               placeholder="e.g. Neraj Lal" 
                               class="w-full px-5 py-3 bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                        @error('instructor_name') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-3 pl-1">Course Price (INR)</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-muted font-[700] text-[14px]">₹</span>
                            <input type="number" name="price" required 
                                   value="{{ old('price', $course->price ?? '') }}" 
                                   placeholder="4999" 
                                   class="w-full pl-10 pr-5 py-3 bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                        </div>
                        @error('price') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-3 pl-1">Thumbnail / Background Color</label>
                        <input type="text" name="thumbnail" 
                               value="{{ old('thumbnail', $course->thumbnail ?? '') }}" 
                               placeholder="e.g. bg-blue-500 or image-url" 
                               class="w-full px-5 py-3 bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[12px] font-[700] text-navy uppercase tracking-widest">
                    </div>
                </div>

                <div class="pt-8 border-t border-border flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 py-4 bg-navy text-white rounded-[8px] font-[700] text-[14px] uppercase tracking-widest hover:bg-primary transition-all shadow-sm">
                        {{ isset($course) ? 'Apply Global Changes' : 'Initialize Curriculum' }}
                    </button>
                    <a href="{{ route('admin.courses.index') }}" class="py-4 px-[32px] bg-border/50 text-muted rounded-[8px] font-[700] text-[14px] uppercase tracking-widest hover:bg-border text-center transition-all">
                        Discard
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
