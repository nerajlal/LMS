@extends('layouts.admin')

@section('title', 'Upload Material')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-6">
    <div class="flex items-center gap-6">
        <a href="{{ route('trainer.study-materials.index') }}" class="w-12 h-12 rounded-[12px] bg-white border border-border flex items-center justify-center text-navy hover:text-primary transition-all shadow-sm">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight uppercase">Upload Material</h1>
            <p class="text-muted text-[14px] font-[500] mt-1">Select a course and upload relevant PDFs or documents.</p>
        </div>
    </div>

    <div class="bg-white p-[32px] rounded-[12px] border border-border shadow-sm">
        <form action="{{ route('trainer.study-materials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[11px] font-[800] text-navy uppercase tracking-wider mb-2 pl-1">Target Course</label>
                    <select name="course_id" required 
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy appearance-none">
                        <option value="">Select the course this material belongs to...</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-[800] text-navy uppercase tracking-wider mb-2 pl-1">Display Title</label>
                    <input type="text" name="title" required placeholder="e.g., Week 1 - Introduction to Web Development.pdf"
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                </div>

                <div>
                    <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-[8px] pl-1">File Upload (PDF, DOC, ZIP)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-border border-dashed rounded-[12px] hover:border-primary/50 transition-all group">
                        <div class="space-y-2 text-center">
                            <i class="bi bi-cloud-arrow-up text-[48px] text-muted group-hover:text-primary transition-colors"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-[700] text-primary hover:text-orange-600 focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="file" type="file" class="sr-only" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-[11px] text-muted font-[600] uppercase tracking-widest">
                                PDF, DOC, ZIP up to 20MB
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-border flex items-center justify-end gap-6">
                <a href="{{ route('trainer.study-materials.index') }}" class="text-[14px] font-[800] text-muted hover:text-navy px-4 tracking-wider uppercase">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-primary text-white font-[800] text-[13px] rounded-[12px] hover:bg-orange-600 transition-all uppercase tracking-widest shadow-xl shadow-orange-500/20">
                    Begin Upload
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
