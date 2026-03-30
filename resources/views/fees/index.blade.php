@extends('layouts.app')

@section('title', 'My Billing & Fees - EduLMS')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Billing Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-[16px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-shield-lock-fill text-primary text-2xl md:text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Billing & <span class="text-primary">Ledger</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Secure Financial Intelligence Oversight</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-[16px] backdrop-blur-sm">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></div>
                <span class="text-[10px] font-[800] text-slate-300 uppercase tracking-widest">PCI-DSS Encrypted Sync</span>
            </div>
        </div>
    </div>

    <!-- Billing Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $totalArrears = $allFees->sum('total_amount');
            $totalPaid = $allFees->sum('paid_amount');
            $totalOutstanding = $totalArrears - $totalPaid;
        @endphp

        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm flex items-center gap-5 transition-all hover:shadow-xl hover:-translate-y-1 group">
            <div class="w-14 h-14 bg-slate-50 text-navy rounded-[16px] flex items-center justify-center text-2xl shadow-inner group-hover:bg-navy group-hover:text-white transition-all">
                <i class="bi bi-receipt"></i>
            </div>
            <div>
                <div class="text-[10px] font-[900] text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Assessment Value</div>
                <div class="text-2xl font-[900] text-navy leading-none tracking-tight">₹{{ number_format($totalArrears) }}</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm flex items-center gap-5 transition-all hover:shadow-xl hover:-translate-y-1 group">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-[16px] flex items-center justify-center text-2xl shadow-inner group-hover:bg-emerald-500 group-hover:text-white transition-all">
                <i class="bi bi-patch-check-fill"></i>
            </div>
            <div>
                <div class="text-[10px] font-[900] text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Settled Credit</div>
                <div class="text-2xl font-[900] text-navy leading-none tracking-tight">₹{{ number_format($totalPaid) }}</div>
            </div>
        </div>

        <div class="bg-navy p-6 rounded-[24px] border border-navy shadow-lg shadow-navy/10 flex items-center gap-5 transition-all hover:shadow-2xl hover:-translate-y-1 group">
            <div class="w-14 h-14 bg-white/10 text-primary rounded-[16px] flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div class="text-[10px] font-[900] text-slate-300 uppercase tracking-widest mb-1.5 leading-none">Settlement Required</div>
                <div class="text-2xl font-[900] text-white leading-none tracking-tight">₹{{ number_format($totalOutstanding) }}</div>
            </div>
        </div>
    </div>

    <!-- Fees Table -->
    <div class="bg-white rounded-[24px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full scrollbar-hide focus:outline-none">
            <table class="w-full text-left border-collapse">
                <thead class="hidden md:table-header-group">
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Product Description</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Valuation</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Verification</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 block md:table-row-group">
                    @forelse($allFees as $fee)
                        @php
                            $statusStyles = [
                                'paid' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'partially_paid' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'pending' => 'bg-red-50 text-red-600 border-red-100',
                            ];
                            $style = $statusStyles[$fee->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                        @endphp
                        <tr class="hover:bg-slate-50/30 transition-colors group block md:table-row">
                            <td class="px-6 py-5 block md:table-cell">
                                <div class="flex justify-between items-start md:block">
                                    <div>
                                        <div class="text-[14px] font-[900] text-navy leading-tight mb-1 group-hover:text-primary transition-colors uppercase leading-none">{{ $fee->course->title ?? 'Platform Access' }}</div>
                                        <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                            <span class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest">Batch: {{ $fee->user->admissions->where('course_id', $fee->course_id)->first()?->batch?->name ?? 'Sync Pending' }}</span>
                                            <span class="hidden md:inline w-1 h-1 bg-slate-300 rounded-full"></span>
                                            <span class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest">ID: #FE-{{ str_pad($fee->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </div>
                                    <div class="md:hidden">
                                        <span class="px-2.5 py-1 {{ $style }} rounded-lg text-[9px] font-[900] uppercase tracking-widest border shadow-sm">
                                            {{ str_replace('_', ' ', $fee->status) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3 md:py-5 block md:table-cell border-t md:border-none border-slate-50">
                                <div class="flex justify-between items-baseline md:block">
                                    <span class="md:hidden text-[10px] font-[800] text-slate-400 uppercase tracking-widest">Valuation</span>
                                    <div>
                                        <div class="flex items-baseline gap-2">
                                            <div class="text-[14px] font-[900] text-navy tracking-tight">₹{{ number_format($fee->total_amount) }}</div>
                                            @if($fee->original_amount && $fee->original_amount > $fee->total_amount)
                                                <div class="text-[11px] font-[700] text-slate-400 line-through decoration-red-400/50 decoration-2">₹{{ number_format($fee->original_amount) }}</div>
                                            @endif
                                        </div>
                                        <div class="text-[9px] text-emerald-500 font-[900] uppercase tracking-widest mt-0.5">
                                            Verified Credit: ₹{{ number_format($fee->paid_amount) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="px-2.5 py-1 {{ $style }} rounded-lg text-[9px] font-[900] uppercase tracking-widest border shadow-sm">
                                    {{ str_replace('_', ' ', $fee->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right block md:table-cell border-t md:border-none border-slate-50">
                                @if($fee->status !== 'paid')
                                    <a href="{{ route('payments.create', ['fee_id' => $fee->id]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-navy text-white text-[10px] font-[900] uppercase tracking-widest rounded-[12px] hover:bg-primary transition-all shadow-lg shadow-navy/10 active:scale-95 w-full md:w-auto justify-center">
                                        <span class="hidden md:inline">Initiate Settlement</span>
                                        <span class="md:hidden">Pay Balance</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                @else
                                    <div class="flex items-center justify-end gap-2 text-emerald-500">
                                        <i class="bi bi-patch-check-fill"></i>
                                        <span class="text-[10px] font-[900] uppercase tracking-widest italic">Fully Verified</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="block md:table-row">
                            <td colspan="4" class="px-8 py-20 text-center text-slate-400 font-[800] italic uppercase tracking-[0.2em] text-[10px] block w-full whitespace-normal">Registry Protocol: Zero Financial Records Detected</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
