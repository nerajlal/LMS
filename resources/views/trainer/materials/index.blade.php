@extends('layouts.admin')

@section('title', 'Manage Resources')

@section('content')
<div class="space-y-8">
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-folder2-open text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Study <span class="text-primary">Materials</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Manage educational resources</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full scrollbar-hide">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider min-w-[200px]">Resource Title</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden md:table-cell">Target Course</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden sm:table-cell">Format</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-center hidden lg:table-cell">Filesize</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
            <tbody class="divide-y divide-border">
                @forelse($materials as $material)
                <tr class="hover:bg-slate-50/30 transition-colors group">
                    <td class="px-6 py-5">
                        <div class="text-[14px] font-[800] text-navy leading-tight group-hover:text-primary transition-colors">{{ $material->title }}</div>
                        <div class="md:hidden mt-1.5 flex items-center gap-2">
                             <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded-[4px] text-[9px] font-[900] uppercase tracking-widest border border-slate-200">
                                {{ $material->course->title ?? 'General' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-[13px] font-[600] text-slate-500 hidden md:table-cell">
                        <div class="truncate max-w-[180px]">{{ $material->course->title ?? 'General' }}</div>
                    </td>
                    <td class="px-6 py-5 hidden sm:table-cell">
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-[6px] text-[10px] font-[900] uppercase tracking-widest border border-slate-200">
                            {{ $material->file_type ?? 'PDF' }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-[13px] font-[700] text-navy text-center hidden lg:table-cell">
                        {{ $material->file_size ?? '2.4 MB' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 text-right">
                            <form action="{{ route('trainer.study-materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Remove this material?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-[32px] h-[32px] bg-red-50 text-red-500 rounded-[8px] flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-100">
                                    <i class="bi bi-trash text-[16px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-[60px] text-center">
                        <div class="flex flex-col items-center gap-4">
                            <i class="bi bi-folder2-open text-[64px] text-border"></i>
                            <p class="text-muted font-[600]">You haven't uploaded any materials yet.</p>
                            {{-- <a href="{{ route('trainer.study-materials.create') }}" class="text-primary font-[700] hover:underline">Upload your first resource</a> --}}
                        </div>
                    </td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>

    @if($materials->hasPages())
    <div class="mt-6">
        {{ $materials->links() }}
    </div>
    @endif
</div>
@endsection
