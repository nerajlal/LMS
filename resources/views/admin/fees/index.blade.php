@extends('layouts.admin')

@section('title', 'Financial Management')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Fee Tracking</h1>
            <p class="text-slate-500 mt-1 font-medium italic">Manage student payments and outstanding receivables</p>
        </div>
    </div>

    <!-- Financial Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl flex items-center gap-6 relative overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-50 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-3xl shrink-0">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Outstanding Receivables</div>
                <div class="text-3xl font-black text-slate-900 leading-none">₹{{ number_format($stats['total_due']) }}</div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl flex items-center gap-6 relative overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-50 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-3xl shrink-0">
                <i class="bi bi-wallet2"></i>
            </div>
            <div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Collected</div>
                <div class="text-3xl font-black text-slate-900 leading-none">₹{{ number_format($stats['total_collected']) }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Student</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Total Amount</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Paid</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($fees as $fee)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-slate-900 leading-tight mb-1">{{ $fee->user->name ?? 'User Deleted' }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">ID: {{ $fee->id }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-sm font-black text-slate-900">₹{{ number_format($fee->total_amount) }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-emerald-600">₹{{ number_format($fee->paid_amount) }}</div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusStyles = [
                                    'paid'    => 'bg-emerald-50 text-emerald-600',
                                    'pending' => 'bg-amber-50 text-amber-600',
                                    'overdue' => 'bg-red-50 text-red-600',
                                ];
                                $style = $statusStyles[$fee->status] ?? 'bg-slate-50 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 {{ $style }} rounded-lg text-[10px] font-black uppercase tracking-widest">
                                {{ $fee->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            @if($fee->status !== 'paid')
                                <form action="{{ route('admin.fees.mark-paid', $fee->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#e3000f] transition-all shadow-lg hover:shadow-red-500/20 active:scale-95">
                                        Mark as Paid
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Settled</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-400 italic font-bold">No fee records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fees->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
            {{ $fees->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
