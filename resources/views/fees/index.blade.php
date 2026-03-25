@extends('layouts.app')

@section('title', 'My Billing & Fees - EduLMS')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight">Billing & Payments</h1>
            <p class="text-muted mt-1 font-[500]">Manage your course fees and payment history</p>
        </div>
        <div class="flex items-center gap-4 bg-white p-2 rounded-[12px] border border-border shadow-sm">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-[10px] flex items-center justify-center text-xl">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="pr-4">
                <div class="text-[10px] font-[800] text-muted uppercase tracking-widest">Total Paid</div>
                <div class="text-xl font-[800] text-navy">₹{{ number_format($fees->sum('paid_amount')) }}</div>
            </div>
        </div>
    </div>

    <!-- Fees Table -->
    <div class="bg-white rounded-[12px] border border-border shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Course Enrollment</th>
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Fee Structure</th>
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Payment Status</th>
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
@forelse($fees as $fee)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="text-[14px] font-[800] text-navy leading-tight mb-1 group-hover:text-primary transition-colors">{{ $fee->course->title ?? 'N/A' }}</div>
                            <div class="text-[11px] text-muted font-[600] italic">Invoice #FE-{{ str_pad($fee->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-baseline gap-2">
                                <span class="text-[15px] font-[800] text-navy">₹{{ number_format($fee->total_amount) }}</span>
                                <span class="text-[11px] text-muted font-[600]">Total</span>
                            </div>
                            <div class="text-[11px] text-emerald-600 font-[700] uppercase tracking-wide">Paid: ₹{{ number_format($fee->paid_amount) }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <span @class([
                                'px-3 py-1 rounded-[8px] text-[10px] font-[800] uppercase tracking-widest',
                                'bg-emerald-50 text-emerald-600' => $fee->status === 'paid',
                                'bg-amber-50 text-amber-600' => $fee->status === 'partially_paid',
                                'bg-red-50 text-red-600' => $fee->status === 'pending',
                            ])>
                                {{ str_replace('_', ' ', $fee->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            @if($fee->status !== 'paid')
                                <a href="{{ route('payments.create', ['fee_id' => $fee->id]) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-[11px] font-[800] uppercase tracking-widest rounded-[12px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/10">
                                    Pay Now <i class="bi bi-arrow-right"></i>
                                </a>
                            @else
                                <span class="text-[11px] font-[800] text-slate-300 uppercase tracking-widest italic">Fully Settled</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-muted font-[600] italic">No billing records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
