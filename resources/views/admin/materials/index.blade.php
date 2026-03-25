@extends('layouts.admin')

@section('title', 'Course Materials')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight uppercase">Material Management</h1>
            <p class="text-muted text-[14px] font-[500] mt-1">Global directory of all uploaded course resources.</p>
        </div>
        <a href="{{ route('admin.study-materials.create') }}" class="px-8 py-3.5 bg-primary text-white font-[800] text-[13px] rounded-[12px] hover:bg-orange-600 transition-all flex items-center gap-3 uppercase tracking-widest shadow-xl shadow-orange-500/20">
            <i class="bi bi-plus-lg text-lg"></i>
            <span>Add New Material</span>
        </a>
    </div>

    <div class="bg-white rounded-[12px] border border-border shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-border">
                    <th class="p-[20px] text-[14px] font-[700] text-navy">Title</th>
                    <th class="p-[20px] text-[14px] font-[700] text-navy">Course</th>
                    <th class="p-[20px] text-[14px] font-[700] text-navy">Type</th>
                    <th class="p-[20px] text-[14px] font-[700] text-navy text-center">Size</th>
                    <th class="p-[20px] text-[14px] font-[700] text-navy text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($materials as $material)
                <tr class="hover:bg-border/5 transition-colors">
                    <td class="p-[20px] text-[14px] font-[500] text-navy">{{ $material->title }}</td>
                    <td class="p-[20px] text-[14px] font-[500] text-navy">{{ $material->course->title }}</td>
                    <td class="p-[20px]">
                        <span class="px-2 py-1 bg-border/50 text-muted rounded text-[10px] font-[800] uppercase tracking-wider">
                            {{ $material->file_type ?? 'PDF' }}
                        </span>
                    </td>
                    <td class="p-[20px] text-[14px] font-[500] text-muted text-center">{{ $material->file_size ?? '2.4 MB' }}</td>
                    <td class="p-[20px] text-right">
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('admin.study-materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Remove this material?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-[32px] h-[32px] bg-red-500 text-white rounded-[6px] flex items-center justify-center hover:bg-red-600 transition-all">
                                    <i class="bi bi-trash-fill text-[14px]"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-[40px] text-center text-muted font-[500]">
                        <div class="flex flex-col items-center gap-3">
                            <i class="bi bi-folder2-open text-[48px] opacity-20"></i>
                            <p>No materials found. Start by adding one!</p>
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
