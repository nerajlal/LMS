@extends('layouts.admin')

@section('title', 'Study Materials - Admin')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-folder2-open text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase leading-none">Resource <span class="text-primary">Vault</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-2">Manage library of global course materials</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-[16px] backdrop-blur-sm">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></div>
                <span class="text-[10px] font-[800] text-slate-300 uppercase tracking-widest">Global Asset Sync Active</span>
            </div>
        </div>
    </div>

    <!-- Data Table Console -->
    <div class="bg-white rounded-[20px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden">
        <div class="overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest">Asset Details</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest hidden md:table-cell">Target Course</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest hidden md:table-cell">Technical Spec</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest text-center hidden md:table-cell">Payload</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($materials as $material)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-[10px] bg-navy/5 flex items-center justify-center text-navy shrink-0 border border-navy/5 group-hover:bg-navy group-hover:text-white transition-all">
                                    <i class="bi bi-file-earmark-text text-lg"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-[13px] font-[800] text-navy truncate break-all group-hover:text-primary transition-colors max-w-[200px] md:max-w-xs">{{ $material->title }}</div>
                                    <div class="text-[10px] text-slate-500 font-[600] uppercase tracking-wider mt-0.5 md:hidden">{{ $material->course->title }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 hidden md:table-cell">
                            <span class="text-[13px] font-[700] text-slate-600 line-clamp-1">{{ $material->course->title }}</span>
                        </td>
                        <td class="p-5 hidden md:table-cell">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full text-[9px] font-[900] uppercase tracking-widest border border-slate-200 shadow-inner">
                                {{ $material->file_type ?? 'PDF' }}
                            </span>
                        </td>
                        <td class="p-5 text-center hidden md:table-cell">
                            <div class="text-[12px] font-[800] text-slate-500 uppercase tracking-tighter">{{ $material->file_size ?? '2.4 MB' }}</div>
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex items-center justify-end gap-2 px-1">
                                <form action="{{ route('admin.study-materials.destroy', $material) }}" method="POST" onsubmit="return confirm('Expunge this asset from the vault?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 bg-pink-50 text-pink-600 rounded-[10px] flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all border border-pink-100 shadow-sm">
                                        <i class="bi bi-trash-fill text-[14px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center">
                            <div class="flex flex-col items-center gap-4 opacity-30">
                                <i class="bi bi-layers text-6xl text-navy"></i>
                                <p class="text-[10px] font-[900] text-navy uppercase tracking-[0.2em]">The vault is currently empty</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
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
