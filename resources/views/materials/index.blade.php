@extends('layouts.app')

@section('title', 'Study Materials')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-[28px] font-[800] text-navy tracking-tight">Study Materials</h1>
        <p class="text-muted text-[16px] font-[500] mt-1">Access all your course resources, PDFs, and guides in one place.</p>
    </div>

    @if($materials->isEmpty())
        <div class="bg-white rounded-[12px] border border-border p-[60px] text-center">
            <div class="flex flex-col items-center gap-4">
                <i class="bi bi-folder2 text-[64px] text-border"></i>
                <p class="text-muted font-[600]">No materials available at the moment.</p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($materials as $material)
            <div class="bg-white p-[24px] rounded-[12px] border border-border shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-[48px] h-[48px] rounded-[10px] bg-accent text-primary flex items-center justify-center text-[20px]">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>
                    <span class="text-[10px] font-[800] text-muted uppercase tracking-wider bg-border/50 px-2 py-1 rounded">
                        {{ $material->file_type ?? 'PDF' }}
                    </span>
                </div>
                <h3 class="text-[16px] font-[800] text-navy mb-2 line-clamp-2">{{ $material->title }}</h3>
                <p class="text-[13px] text-muted font-[600] mb-6">{{ $material->course->title }}</p>
                
                <div class="flex items-center justify-between pt-4 border-t border-border">
                    <span class="text-[12px] font-[700] text-muted">{{ $material->file_size ?? '2.4 MB' }}</span>
                    <a href="{{ $material->file_path }}" target="_blank" class="text-primary font-[800] text-[13px] flex items-center gap-2 hover:gap-3 transition-all">
                        <span>Download</span>
                        <i class="bi bi-arrow-down-circle-fill"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
