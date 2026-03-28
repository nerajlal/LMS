@extends('layouts.admin')

@section('title', 'Financial Management')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-wallet2 text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Financial <span class="text-primary">Ledger</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Automated fee tracking & receivables</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-[16px] backdrop-blur-sm">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></div>
                <span class="text-[10px] font-[800] text-slate-300 uppercase tracking-widest">Real-time Financial Sync</span>
            </div>
        </div>
    </div>

    <!-- Financial Stats Grid -->
    <!-- High-Density Intelligence Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="relative group bg-white p-6 rounded-[20px] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-50 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10 flex items-center gap-5">
                <div class="w-14 h-14 bg-orange-50 text-primary rounded-[14px] flex items-center justify-center text-2xl shrink-0 shadow-inner group-hover:scale-110 transition-transform">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <div class="text-[10px] font-[900] text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Total Receivables</div>
                    <div class="text-2xl font-[900] text-navy leading-none tracking-tight">₹{{ number_format($stats['total_due']) }}</div>
                </div>
            </div>
        </div>

        <div class="relative group bg-navy p-6 rounded-[20px] border border-navy shadow-lg shadow-navy/10 hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary/20 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10 flex items-center gap-5">
                <div class="w-14 h-14 bg-white/10 text-primary rounded-[14px] flex items-center justify-center text-2xl shrink-0 shadow-inner group-hover:scale-110 transition-transform">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="text-[10px] font-[900] text-slate-300 uppercase tracking-widest mb-1.5 leading-none">Settled Revenue</div>
                    <div class="text-2xl font-[900] text-white leading-none tracking-tight">₹{{ number_format($stats['total_collected']) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[20px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full scrollbar-hide focus:outline-none">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider whitespace-nowrap">Learner Profile</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider whitespace-nowrap">Product Path</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider whitespace-nowrap">Assessment Value</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden md:table-cell whitespace-nowrap">Paid Credit</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider whitespace-nowrap">Settlement</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right whitespace-nowrap">Verification</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($fees as $fee)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="text-[14px] font-[800] text-navy leading-tight mb-1 group-hover:text-primary transition-colors uppercase leading-none">{{ $fee->user->name ?? 'User Deleted' }}</div>
                                <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest">UID: #{{ sprintf('%03d', $fee->id) }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-[13px] font-[800] text-navy truncate max-w-[150px]">{{ $fee->course->title ?? 'General Program' }}</div>
                                <div class="text-[9px] text-slate-400 font-[700] uppercase tracking-widest mt-1">
                                    Batch: {{ $fee->user->admissions->where('course_id', $fee->course_id)->first()?->batch?->name ?? 'Unassigned' }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-baseline gap-2">
                                    <div class="text-[14px] font-[900] text-navy">₹{{ number_format($fee->total_amount) }}</div>
                                    @if($fee->original_amount && $fee->original_amount > $fee->total_amount)
                                        <div class="text-[11px] font-[700] text-slate-400 line-through decoration-red-400/50 decoration-2">₹{{ number_format($fee->original_amount) }}</div>
                                    @endif
                                </div>
                                <div class="text-[9px] text-slate-400 font-[700] uppercase tracking-widest mt-0.5">Base Invoice</div>
                            </td>
                            <td class="px-6 py-5 hidden md:table-cell">
                                <div class="text-[14px] font-[800] text-emerald-600">₹{{ number_format($fee->paid_amount) }}</div>
                                <div class="text-[9px] text-slate-400 font-[700] uppercase tracking-widest mt-0.5">Verified Credit</div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $statusStyles = [
                                        'paid'    => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'overdue' => 'bg-red-50 text-red-600 border-red-100',
                                    ];
                                    $style = $statusStyles[$fee->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                                @endphp
                                <span class="px-2.5 py-1 {{ $style }} rounded-lg text-[9px] font-[900] uppercase tracking-widest border shadow-sm">
                                    {{ $fee->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                @if($fee->status !== 'paid')
                                    <form action="{{ route('admin.fees.mark-paid', $fee->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-navy text-white text-[10px] font-[900] uppercase tracking-widest rounded-[10px] hover:bg-primary transition-all shadow-md active:scale-95">
                                            Mark Settled
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center justify-end gap-2 text-slate-300">
                                        <i class="bi bi-patch-check-fill text-emerald-500"></i>
                                        <span class="text-[10px] font-[800] uppercase tracking-widest">Settled</span>
                                    </div>
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
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $fees->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
