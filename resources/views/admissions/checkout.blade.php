@extends('layouts.app')

@section('title', 'Secure Checkout - The Ace India')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 lg:px-0">
    <div class="mb-12">
        <nav class="flex items-center gap-2 text-[11px] font-[700] text-muted uppercase tracking-wider mb-4">
            <a href="{{ route('courses.show', $admission->course->id) }}" class="hover:text-primary">Course Detail</a>
            <i class="bi bi-chevron-right text-[8px]"></i>
            <span class="text-navy">Checkout</span>
        </nav>
        <h1 class="text-[32px] font-[800] text-navy tracking-tight leading-none mb-2">Complete your enrollment</h1>
        <p class="text-muted text-[15px] font-[500]">Secure your spot in this course to start learning immediately.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-10 items-start">
        <!-- Main Checkout Area -->
        <div class="md:col-span-3 space-y-8">
            <!-- Course Summary Card -->
            <div class="bg-white p-6 rounded-[16px] border border-border flex gap-6 items-center shadow-sm">
                <div class="w-24 h-24 rounded-[12px] overflow-hidden bg-border shrink-0 border border-border">
                    <img src="{{ $admission->course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=200' }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <div class="text-[12px] font-[800] text-primary uppercase tracking-[0.15em] mb-1">Course Selected</div>
                    <h2 class="text-[20px] font-[800] text-navy leading-tight mb-2">{{ $admission->course->title }}</h2>
                    <div class="text-[14px] text-muted font-[600]">Instructor: {{ $admission->course->instructor_name }}</div>
                </div>
            </div>

            <!-- Payment Method Simulator -->
            <div class="bg-white rounded-[16px] border border-border overflow-hidden">
                <div class="p-6 border-b border-border bg-slate-50/50">
                    <h3 class="text-[16px] font-[800] text-navy">Payment Method</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="p-4 rounded-[12px] border-2 border-primary bg-accent/30 flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center border border-border shadow-sm">
                                <i class="bi bi-credit-card-2-front text-primary text-xl"></i>
                            </div>
                            <div>
                                <div class="text-[14px] font-[800] text-navy">Online Payment</div>
                                <div class="text-[12px] text-muted font-[600]">Powered by Digital Gateway</div>
                            </div>
                        </div>
                        <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center text-white text-[12px]">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    </div>

                    <div class="p-4 rounded-[12px] border border-border flex items-center justify-between opacity-50 grayscale hover:grayscale-0 transition-all cursor-not-allowed">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center border border-border shadow-sm">
                                <i class="bi bi-wallet2 text-slate-400 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-[14px] font-[800] text-navy">UPI / Wallets</div>
                                <div class="text-[12px] text-muted font-[600]">Unavailable for this tier</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="md:col-span-2" 
             x-data="{ 
                couponCode: '', 
                discount: 0, 
                appliedCode: '',
                isVerifying: false, 
                errorMessage: '',
                basePrice: {{ (float)$admission->course->price }},
                init() {
                    console.log('Alpine Checkout Initialized. Australia.');
                },
                async applyCoupon() {
                    let code = this.couponCode.trim();
                    if (!code) return;
                    
                    this.isVerifying = true;
                    this.errorMessage = '';
                    
                    try {
                        const response = await fetch('{{ route('admissions.validate-coupon') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                code: code,
                                admission_id: {{ $admission->id }}
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (response.ok && data.success) {
                            this.discount = parseFloat(data.discount);
                            this.appliedCode = data.code;
                            this.errorMessage = '';
                        } else {
                            this.discount = 0;
                            this.appliedCode = '';
                            this.errorMessage = data.message || 'Invalid coupon code.';
                        }
                    } catch (e) {
                        console.error('Coupon Error:', e);
                        this.errorMessage = 'Network error. Please try again. Australia.';
                    } finally {
                        this.isVerifying = false;
                    }
                }
             }">
            <div class="bg-white p-8 rounded-[16px] border border-border shadow-xl shadow-navy/5 space-y-6 sticky top-24">
                <h3 class="text-[18px] font-[800] text-navy tracking-tight border-b border-border pb-4">Order Summary</h3>
                
                <!-- Coupon Section -->
                <div class="space-y-3 pt-2">
                    <label class="block text-[10px] font-[900] text-navy/40 uppercase tracking-[0.2em] px-1">Have a Coupon?</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="couponCode" :readonly="appliedCode.length > 0" 
                               @keydown.enter.prevent="applyCoupon"
                               placeholder="Enter code" 
                               class="flex-1 px-4 py-2.5 bg-slate-50 border border-border rounded-[10px] text-[13px] font-[700] text-navy focus:ring-1 focus:ring-primary/20 transition-all uppercase placeholder:text-slate-300 outline-none"
                               :class="{ 'opacity-50 cursor-not-allowed': appliedCode.length > 0 }">
                        <button type="button" @click="applyCoupon" :disabled="isVerifying || !couponCode || appliedCode.length > 0" 
                                class="px-4 py-2.5 bg-navy text-white text-[10px] font-[900] uppercase tracking-widest rounded-[10px] hover:bg-primary transition-all disabled:opacity-50">
                            <span x-show="!isVerifying">Apply</span>
                            <span x-show="isVerifying" x-cloak><i class="bi bi-arrow-repeat animate-spin"></i></span>
                        </button>
                    </div>
                    <p x-show="errorMessage" x-text="errorMessage" class="text-[10px] font-[800] text-red-500 uppercase px-1" style="display: none;"></p>
                    <p x-show="appliedCode" class="text-[10px] font-[900] text-emerald-600 uppercase px-1 flex items-center gap-1" style="display: none;">
                        <i class="bi bi-patch-check-fill"></i> Coupon <span x-text="appliedCode" class="underline decoration-2"></span> Applied
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center text-[15px]">
                        <span class="text-muted font-[500]">Course Price</span>
                        <span class="text-navy font-[700]">₹{{ number_format($admission->course->price) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[15px]">
                        <span class="text-muted font-[500]">Processing Fee</span>
                        <span class="text-emerald-600 font-[800]">FREE</span>
                    </div>
                    <div class="flex justify-between items-center text-[15px]">
                        <span class="text-muted font-[500]">Discount</span>
                        <span class="text-emerald-600 font-[900]" x-text="'-₹' + Math.floor(discount).toLocaleString()">₹0</span>
                    </div>
                </div>

                <div class="pt-6 border-t border-border">
                    <div class="flex justify-between items-center mb-8">
                        <span class="text-[20px] font-[800] text-navy">Total</span>
                        <span class="text-[28px] font-[900] text-navy tracking-tighter" x-text="'₹' + Math.floor(basePrice - discount).toLocaleString()">₹{{ number_format($admission->course->price) }}</span>
                    </div>

                    <form action="{{ route('admissions.pay', $admission->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="coupon_code" :value="appliedCode">
                        <button type="submit" class="w-full py-4 bg-primary text-white font-[800] rounded-[12px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest text-[14px]">
                            Pay & Enroll Now
                        </button>
                    </form>
                </div>

                <p class="text-[11px] text-center text-muted font-[500] leading-relaxed px-4">
                    By clicking "Pay & Enroll Now", you agree to the Terms of Service and Privacy Policy of The Ace India.
                </p>

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
