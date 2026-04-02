@extends('layouts.app')

@section('title', 'Secure Checkout - The Ace India')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 lg:px-0">
    <div class="mb-12">
        @php
            $meta = null;
            if ($admission->batch_id) {
                $meta = $admission->batch->getDisplayMetadata();
            } else {
                $meta = (object)[
                    'title' => $admission->course->title,
                    'instructor_name' => $admission->course->instructor_name,
                    'thumbnail' => $admission->course->thumbnail,
                    'price' => $admission->course->price
                ];
            }
        @endphp
        <nav class="flex items-center gap-2 text-[11px] font-[700] text-muted uppercase tracking-wider mb-4">
            <a href="{{ route('courses.index') }}" class="hover:text-primary text-[10px]">Back to Catalog</a>
            <i class="bi bi-chevron-right text-[8px]"></i>
            <span class="text-navy text-[10px]">{{ $meta->title }}</span>
        </nav>
        <h1 class="text-[32px] font-[800] text-navy tracking-tight leading-none mb-2">Secure Enrollment</h1>
        <p class="text-muted text-[15px] font-[500]">You are one step away from joining your live cohort.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-10 items-start">
        <!-- Main Checkout Area -->
        <div class="md:col-span-3 space-y-8">
            <!-- Course Summary Card -->
            <div class="bg-white p-6 rounded-[24px] border border-border flex gap-6 items-center shadow-xl shadow-navy/5">
                <div class="w-24 h-24 rounded-[18px] overflow-hidden bg-border shrink-0 border-2 border-white shadow-sm">
                    <img src="{{ $meta->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=200' }}" class="w-full h-full object-cover text-[10px]">
                </div>
                <div class="flex-1">
                    <div class="text-[10px] font-[900] text-primary uppercase tracking-[0.2em] mb-1">Selected Curriculum</div>
                    <h2 class="text-[20px] font-[900] text-navy leading-tight mb-1">{{ $meta->title }}</h2>
                    <div class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest italic opacity-80">
                        @if($admission->batch_id)
                            Live Batch • {{ $admission->batch->name }}
                        @else
                            Self-Paced Recorded Course
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Method Simulator -->
            <div class="bg-white rounded-[24px] border border-border overflow-hidden shadow-sm">
                <div class="p-8 border-b border-border bg-slate-50/50">
                    <h3 class="text-[14px] font-[900] text-navy uppercase tracking-widest">Payment Gateway</h3>
                </div>
                <div class="p-8 space-y-4">
                    <div class="p-5 rounded-[20px] border-2 border-primary bg-primary/5 flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center border border-primary/20 shadow-sm text-primary">
                                <i class="bi bi-shield-lock-fill text-xl"></i>
                            </div>
                            <div>
                                <div class="text-[14px] font-[900] text-navy">Secure Card / UPI</div>
                                <div class="text-[11px] text-slate-400 font-[600] uppercase tracking-widest">Encrypted Checkout Protocol</div>
                            </div>
                        </div>
                        <div class="w-7 h-7 rounded-full bg-primary flex items-center justify-center text-white">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2" 
             x-data="{ 
                discount: {{ $directCoupon ? (float)$directCoupon->discount_amount : 0 }}, 
                appliedCode: '{{ $directCoupon ? $directCoupon->code : '' }}',
                isDirect: {{ $directCoupon ? 'true' : 'false' }},
                basePrice: {{ (float)$meta->price }}
             }">
            <div class="bg-white p-8 rounded-[28px] border border-border shadow-2xl shadow-navy/10 space-y-8 sticky top-24">
                <h3 class="text-[14px] font-[900] text-navy uppercase tracking-[0.2em] border-b border-border pb-6">Financial Ledger</h3>
                
                <!-- Coupon Section (Direct Only) -->
                <div class="space-y-4" x-show="isDirect">
                    <label class="block text-[10px] font-[900] text-navy/40 uppercase tracking-[0.2em] px-1">Active Scholarship Applied</label>

                    <!-- Direct Discount Badge -->
                    <div class="p-5 rounded-[20px] bg-emerald-50 border border-emerald-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-emerald-500/20">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-[10px] font-[900] text-emerald-800 uppercase tracking-widest">Scholarship Active</div>
                            <div class="text-[11px] text-emerald-600 font-[700] mt-0.5 mt-2">Deduction: -₹<span x-text="Math.floor(discount).toLocaleString()"></span></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="flex justify-between items-center text-[14px]">
                        <span class="text-slate-400 font-[600] uppercase tracking-widest">Unit Price</span>
                        <span class="text-navy font-[800]">₹{{ number_format($meta->price) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[14px]">
                        <span class="text-slate-400 font-[600] uppercase tracking-widest">Platform Fee</span>
                        <span class="text-emerald-600 font-[800]">WAIVED</span>
                    </div>
                    <div class="flex justify-between items-center text-[14px]" x-show="discount > 0">
                        <span class="text-slate-400 font-[600] uppercase tracking-widest">Discount</span>
                        <span class="text-rose-500 font-[900]" x-text="'-₹' + Math.floor(discount).toLocaleString()">₹0</span>
                    </div>
                </div>

                <div class="pt-8 border-t border-border">
                    <div class="flex justify-between items-center mb-10">
                        <span class="text-[12px] font-[900] text-navy uppercase tracking-widest">Net Payable</span>
                        <span class="text-[32px] font-[900] text-navy tracking-tighter" x-text="'₹' + Math.floor(basePrice - discount).toLocaleString()">₹{{ number_format($meta->price) }}</span>
                    </div>

                    <form action="{{ route('admissions.pay', $admission->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="coupon_code" :value="appliedCode">
                        <button type="submit" class="w-full py-4 bg-primary text-white font-[800] rounded-[12px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest text-[14px]">
                            Pay & Enroll Now
                        </button>
                    </form>
                </div>

                <div class="flex items-center justify-center gap-6 pt-2 grayscale opacity-40">
                    <i class="bi bi-shield-check text-2xl"></i>
                    <i class="bi bi-lock text-2xl"></i>
                    <i class="bi bi-patch-check text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
