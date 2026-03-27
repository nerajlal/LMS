@extends('layouts.admin')

@section('title', 'Pending Admissions')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-clipboard-check text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Admission <span class="text-primary">Requests</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Validate and manage institutional enrollment</p>
                </div>
            </div>
            @if(request()->has('user_id'))
            <a href="{{ route('admin.admissions.index') }}" class="px-6 py-3.5 bg-white/10 text-white text-[11px] font-[800] uppercase tracking-widest rounded-[12px] hover:bg-white hover:text-navy transition-all backdrop-blur-md border border-white/10">
                <i class="bi bi-x-lg mr-2"></i> Clear Filter
            </a>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-[20px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full scrollbar-hide focus:outline-none">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Student Profile</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden md:table-cell">Applied Program</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Log Status</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right">Approval Controls</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($admissions as $admission)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="text-[14px] font-[800] text-navy leading-tight mb-1 group-hover:text-primary transition-colors uppercase leading-none">{{ $admission->user->name }}</div>
                                <div class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest">{{ $admission->user->email }}</div>
                            </td>
                            <td class="px-6 py-5 hidden md:table-cell">
                                <div class="text-[13px] font-[800] text-navy mb-1 leading-tight uppercase leading-none">{{ $admission->course->title ?? 'N/A' }}</div>
                                <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest italic">Batch: {{ $admission->batch->name ?? 'Primary Batch' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $statusStyles = [
                                        'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'pending'  => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                    ];
                                    $style = $statusStyles[$admission->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                @endphp
                                <span class="px-2.5 py-1 {{ $style }} rounded-lg text-[9px] font-[900] uppercase tracking-widest border">
                                    {{ $admission->status }}
                                </span>
                                <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest mt-1.5">{{ $admission->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($admission->status === 'pending')
                                        <form action="{{ route('admin.admissions.approve', $admission->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-[900] uppercase tracking-widest rounded-[10px] hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.admissions.reject', $admission->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-white text-navy text-[10px] font-[900] uppercase tracking-widest rounded-[10px] border border-slate-200 hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-all">
                                                Reject
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest bg-slate-100 px-3 py-1 rounded-[6px]">Validated</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <p class="text-slate-400 font-bold italic">No admission requests to display.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($admissions->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $admissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
