@extends('layouts.app')

@section('title', 'Make Payment - EduLMS')

@section('content')
<div class="max-w-2xl mx-auto space-y-10">
    <!-- Header -->
    <div class="flex items-center gap-6">
        <a href="{{ route('fees.index') }}" class="w-12 h-12 bg-white rounded-[12px] border border-border flex items-center justify-center text-navy hover:text-primary hover:border-primary transition-all shadow-sm">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight">Complete Payment</h1>
            <p class="text-muted mt-1 font-[500]">Securely pay your course fees via PhonePe</p>
        </div>
    </div>

    <!-- Payment Card -->
    <div class="bg-white rounded-[12px] border border-border shadow-lg overflow-hidden flex flex-col">
        <div class="p-8 bg-navy text-white flex justify-between items-center">
            <div>
                <div class="text-[11px] font-[800] text-primary uppercase tracking-[0.2em] mb-1">Payable Amount</div>
                <div class="text-3xl font-[900]">₹{{ number_format($fees->first()->total_amount - $fees->first()->paid_amount) }}</div>
            </div>
            <div class="w-16 h-16 bg-white/10 rounded-[12px] flex items-center justify-center text-3xl">
                <i class="bi bi-shield-check text-primary"></i>
            </div>
        </div>

        <div class="p-10 space-y-8">
            <div class="space-y-4">
                <div class="flex items-center justify-between text-[14px]">
                    <span class="text-muted font-[600]">Course</span>
                    <span class="text-navy font-[800]">{{ $fees->first()->course->title ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between text-[14px]">
                    <span class="text-muted font-[600]">Invoice Number</span>
                    <span class="text-navy font-[800]">#FE-{{ str_pad($fees->first()->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="h-px bg-border my-4"></div>
                <div class="flex items-center justify-between text-[16px]">
                    <span class="text-navy font-[800]">Total to Pay</span>
                    <span class="text-primary font-[900]">₹{{ number_format($fees->first()->total_amount - $fees->first()->paid_amount) }}</span>
                </div>
            </div>

            <form action="{{ route('payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="fee_id" value="{{ $fees->first()->id }}">
                <input type="hidden" name="amount" value="{{ $fees->first()->total_amount - $fees->first()->paid_amount }}">

                <button type="submit" class="w-full flex items-center justify-center gap-3 py-5 bg-primary text-white font-[800] rounded-[12px] hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20 text-[14px] uppercase tracking-widest">
                    Pay Securely with PhonePe <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="flex items-center justify-center gap-6 opacity-30 grayscale pt-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/UPI-Logo.png/640px-UPI-Logo.png" class="h-6">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Visa_2021.svg/640px-Visa_2021.svg.png" class="h-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/640px-Mastercard-logo.svg.png" class="h-6">
            </div>
        </div>
    </div>
</div>
@endsection
