@extends('layouts.admin')

@section('title', 'Pending Admissions')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Admission Requests</h1>
            <p class="text-slate-500 mt-1 font-medium italic">Review and manage student enrollment applications</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Student Details</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Applied Course</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Current Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Decisions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($admissions as $admission)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-slate-900 leading-tight mb-1">{{ $admission->user->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $admission->user->email }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-xs font-bold text-slate-700 mb-1 leading-tight">{{ $admission->course->title ?? 'N/A' }}</div>
                            <div class="text-[10px] text-slate-400 font-medium italic">Batch: {{ $admission->batch->name ?? 'Default' }}</div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusStyles = [
                                    'approved' => 'bg-emerald-50 text-emerald-600',
                                    'pending'  => 'bg-amber-50 text-amber-600',
                                    'rejected' => 'bg-red-50 text-red-600',
                                ];
                                $style = $statusStyles[$admission->status] ?? 'bg-slate-50 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 {{ $style }} rounded-lg text-[10px] font-black uppercase tracking-widest">
                                {{ $admission->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-3">
                                @if($admission->status === 'pending')
                                    <form action="{{ route('admin.admissions.approve', $admission->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.admissions.reject', $admission->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-red-50 hover:text-red-600 transition-all border border-transparent hover:border-red-100">
                                            Reject
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">No actions pending</span>
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
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
            {{ $admissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
