@extends('layouts.admin')

@section('title', 'Add New Material')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-6">
    <div class="flex items-center gap-6">
        <a href="{{ route('admin.study-materials.index') }}" class="w-12 h-12 rounded-[12px] bg-white border border-border flex items-center justify-center text-navy hover:text-primary transition-all shadow-sm">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight uppercase">Add New Material</h1>
            <p class="text-muted text-[14px] font-[500] mt-1">Upload PDFs, Documents, or Zip files for your courses.</p>
        </div>
    </div>

    <div class="bg-white p-[32px] rounded-[12px] border border-border shadow-sm">
        <form action="{{ route('admin.study-materials.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-[24px]">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-[800] text-navy uppercase tracking-wider mb-2 pl-1">Course Selection</label>
                    <select name="course_id" required 
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy appearance-none">
                        <option value="">Select a course...</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[11px] font-[800] text-navy uppercase tracking-wider mb-2 pl-1">Material Title</label>
                    <input type="text" name="title" required placeholder="e.g., Mastering Full Stack Web Development.pdf"
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                </div>

                <div>
                    <label class="block text-[11px] font-[800] text-navy uppercase tracking-wider mb-2 pl-1">File Path / URL</label>
                    <input type="text" name="file_path" required placeholder="/storage/materials/file.pdf"
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                </div>

                <div class="grid grid-cols-2 gap-[24px]">
                    <div>
                        <label class="block text-[11px] font-[800] text-navy uppercase tracking-wider mb-2 pl-1">Type</label>
                        <input type="text" name="file_type" required placeholder="PDF"
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                    </div>
                    <div>
                        <label class="block text-[11px] font-[800] text-navy uppercase tracking-wider mb-2 pl-1">Size</label>
                        <input type="text" name="file_size" required placeholder="2.4 MB"
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-[15px] font-[600] text-navy">
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-border flex items-center justify-end gap-6">
                <a href="{{ route('admin.study-materials.index') }}" class="text-[14px] font-[800] text-muted hover:text-navy px-4 tracking-wider uppercase">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-primary text-white font-[800] text-[13px] rounded-[12px] hover:bg-orange-600 transition-all uppercase tracking-widest shadow-xl shadow-orange-500/20">
                    Save Material
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
