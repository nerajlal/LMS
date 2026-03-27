@extends('layouts.app')

@section('title', 'My Billing & Fees - EduLMS')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Billing Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-[14px] md:rounded-[16px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-wallet2 text-primary text-2xl md:text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight">Billing & <span class="text-primary">Payments</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Manage your financial commitments</p>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <div class="px-4 py-2 bg-white/5 border border-white/10 rounded-full flex items-center gap-3 backdrop-blur-md">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                    <span class="text-[11px] font-[800] uppercase tracking-widest text-slate-300">Secure Gateway</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Billing Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $totalArrears = $allFees->sum('total_amount');
            $totalPaid = $allFees->sum('paid_amount');
            $totalOutstanding = $totalArrears - $totalPaid;
            
            $billingStats = [
                ['label' => 'Total Arrears', 'value' => $totalArrears, 'icon' => 'bi-briefcase-fill', 'color' => 'text-navy', 'bg' => 'bg-slate-100'],
                ['label' => 'Total Paid', 'value' => $totalPaid, 'icon' => 'bi-check-circle-fill', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
                ['label' => 'Outstanding', 'value' => $totalOutstanding, 'icon' => 'bi-clock-history', 'color' => 'text-primary', 'bg' => 'bg-orange-50'],
            ];
        @endphp

        @foreach($billingStats as $stat)
        <div class="bg-white p-5 rounded-[16px] border border-border shadow-sm flex items-center gap-4 group hover:shadow-md transition-all">
            <div class="w-12 h-12 {{ $stat['bg'] }} {{ $stat['color'] }} rounded-[12px] flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                <i class="bi {{ $stat['icon'] }}"></i>
            </div>
            <div>
                <div class="text-[10px] font-[800] text-muted uppercase tracking-widest mb-1">{{ $stat['label'] }}</div>
                <div class="text-xl font-[900] text-navy">₹{{ number_format($stat['value']) }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Fees Table -->
    <div class="bg-white rounded-[12px] border border-border shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-4 md:px-6 py-4 text-[10px] md:text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Course Enrollment</th>
                        <th class="px-4 md:px-6 py-4 text-[10px] md:text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Fee Structure</th>
                        <th class="px-4 md:px-6 py-4 text-[10px] md:text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Payment Status</th>
                        <th class="px-4 md:px-6 py-4 text-[10px] md:text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @if($allFees->count() > 0)
                        @foreach($allFees as $fee)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-4 md:px-6 py-4">
                                <div class="text-[13px] md:text-[14px] font-[800] text-navy leading-tight mb-1 group-hover:text-primary transition-colors">{{ $fee->course->title ?? 'N/A' }}</div>
                                <div class="text-[11px] text-muted font-[600] italic">Invoice #FE-{{ str_pad($fee->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-4 md:px-6 py-4">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-[14px] md:text-[15px] font-[800] text-navy">₹{{ number_format($fee->total_amount) }}</span>
                                    <span class="text-[10px] md:text-[11px] text-muted font-[600]">Total</span>
                                </div>
                                <div class="text-[10px] md:text-[11px] text-emerald-600 font-[700] uppercase tracking-wide">Paid: ₹{{ number_format($fee->paid_amount) }}</div>
                            </td>
                            <td class="px-4 md:px-6 py-4">
                                <span @class([
                                    'px-3 py-1 rounded-[8px] text-[9px] md:text-[10px] font-[800] uppercase tracking-widest',
                                    'bg-emerald-50 text-emerald-600' => $fee->status === 'paid',
                                    'bg-amber-50 text-amber-600' => $fee->status === 'partially_paid',
                                    'bg-red-50 text-red-600' => $fee->status === 'pending',
                                ])>
                                    {{ str_replace('_', ' ', $fee->status) }}
                                </span>
                            </td>
                            <td class="px-4 md:px-6 py-4 text-right">
                                @if($fee->status !== 'paid')
                                    <a href="{{ route('payments.create', ['fee_id' => $fee->id]) }}" class="inline-flex items-center gap-2 px-4 md:px-6 py-2 md:py-2.5 bg-primary text-white text-[10px] md:text-[11px] font-[800] uppercase tracking-widest rounded-[12px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/10">
                                        Pay <span class="hidden sm:inline">Now</span> <i class="bi bi-arrow-right"></i>
                                    </a>
                                @else
                                    <span class="text-[10px] md:text-[11px] font-[800] text-slate-300 uppercase tracking-widest italic">Fully Settled</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-muted font-[600] italic">No billing records found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
