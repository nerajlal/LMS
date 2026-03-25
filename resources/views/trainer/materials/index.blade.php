@extends('layouts.admin')

@section('title', 'Manage Resources')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight uppercase">Study Materials</h1>
            <p class="text-muted text-[14px] font-[500] mt-1">Upload and manage educational resources for your students.</p>
        </div>
        <a href="{{ route('trainer.study-materials.create') }}" class="px-8 py-3.5 bg-primary text-white font-[800] text-[13px] rounded-[12px] hover:bg-orange-600 transition-all flex items-center gap-3 uppercase tracking-widest shadow-xl shadow-orange-500/20">
            <i class="bi bi-plus-lg text-lg"></i>
            <span>Add New Material</span>
        </a>
    </div>

    <div class="bg-white rounded-[12px] border border-border shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-border bg-border/5">
                    <th class="p-[20px] text-[13px] font-[700] text-navy uppercase tracking-wider">Title</th>
                    <th class="p-[20px] text-[13px] font-[700] text-navy uppercase tracking-wider">Course</th>
                    <th class="p-[20px] text-[13px] font-[700] text-navy uppercase tracking-wider">Type</th>
                    <th class="p-[20px] text-[13px] font-[700] text-navy uppercase tracking-wider text-center">Size</th>
                    <th class="p-[20px] text-[13px] font-[700] text-navy uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($materials as $material)
                <tr class="hover:bg-border/5 transition-colors">
                    <td class="p-[20px] text-[14px] font-[600] text-navy">{{ $material->title }}</td>
                    <td class="p-[20px] text-[14px] font-[500] text-navy">{{ $material->course->title ?? 'Deleted Course' }}</td>
                    <td class="p-[20px]">
                        <span class="px-2 py-1 bg-border/50 text-muted rounded text-[10px] font-[800] uppercase tracking-wider">
                            {{ $material->file_type ?? 'PDF' }}
                        </span>
                    </td>
                    <td class="p-[20px] text-[14px] font-[500] text-muted text-center">{{ $material->file_size ?? '2.4 MB' }}</td>
                    <td class="p-[20px] text-right">
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('trainer.study-materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Remove this material?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-[32px] h-[32px] bg-red-500 text-white rounded-[6px] flex items-center justify-center hover:bg-red-600 transition-all shadow-sm">
                                    <i class="bi bi-trash-fill text-[14px]"></i>
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
                            <a href="{{ route('trainer.study-materials.create') }}" class="text-primary font-[700] hover:underline">Upload your first resource</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($materials->hasPages())
    <div class="mt-6">
        {{ $materials->links() }}
    </div>
    @endif
</div>
@endsection
