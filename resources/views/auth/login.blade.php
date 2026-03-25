@extends('layouts.app')

@section('title', 'Login - EduLMS')

@section('full_page', true)

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    <!-- Left Side: Gradient & Info -->
    <div class="md:w-7/12 bg-gradient-to-br from-[#232526] via-[#414345] to-[#f37021] relative flex items-center justify-center p-8 overflow-hidden">
        <!-- Decorative SVG Circles (Top Left) -->
        <div class="absolute -top-20 -left-20 opacity-20 group">
            <svg width="400" height="400" viewBox="0 0 400 400">
                <circle cx="200" cy="200" r="180" fill="none" stroke="white" stroke-width="1" />
                <circle cx="200" cy="200" r="140" fill="none" stroke="white" stroke-width="1" />
                <circle cx="200" cy="200" r="100" fill="none" stroke="white" stroke-width="1" />
            </svg>
        </div>
        
        <!-- Decorative SVG Circles (Bottom Right) -->
        <div class="absolute -bottom-20 -right-20 opacity-20">
            <svg width="400" height="400" viewBox="0 0 400 400">
                <circle cx="200" cy="200" r="180" fill="none" stroke="white" stroke-width="1" />
                <circle cx="200" cy="200" r="140" fill="none" stroke="white" stroke-width="1" />
                <circle cx="200" cy="200" r="100" fill="none" stroke="white" stroke-width="1" />
            </svg>
        </div>

        <div class="relative z-10 text-center text-white max-w-lg space-y-8">
            <div class="w-[80px] h-[80px] bg-white/20 backdrop-blur-md rounded-[20px] flex items-center justify-center mx-auto shadow-2xl">
                <i class="bi bi-mortarboard-fill text-[40px]"></i>
            </div>
            
            <div class="space-y-4">
                <h1 class="text-[48px] font-[900] tracking-tight leading-tight">EduLMS</h1>
                <p class="text-[18px] font-[500] opacity-90 leading-relaxed">
                    Your complete learning management system. Learn, grow, and achieve.
                </p>
            </div>

            <div class="flex items-center justify-center gap-12 pt-8">
                <div class="text-center">
                    <div class="text-[28px] font-[900]">500+</div>
                    <div class="text-[12px] font-[600] uppercase tracking-widest opacity-70">Courses</div>
                </div>
                <div class="text-center">
                    <div class="text-[28px] font-[900]">2K+</div>
                    <div class="text-[12px] font-[600] uppercase tracking-widest opacity-70">Students</div>
                </div>
                <div class="text-center">
                    <div class="text-[28px] font-[900]">50+</div>
                    <div class="text-[12px] font-[600] uppercase tracking-widest opacity-70">Instructors</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="md:w-5/12 bg-white flex items-center justify-center p-8 lg:p-24 overflow-y-auto">
        <div class="w-full max-w-[400px] space-y-10">
            <div>
                <h2 class="text-[32px] font-[800] text-navy">Sign in</h2>
                <p class="text-muted text-[15px] font-[500] mt-1">Welcome back! Please enter your details.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                @if (session('status'))
                    <div class="p-4 bg-emerald-50 text-emerald-700 text-[14px] font-[600] rounded-[8px] border border-emerald-100">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="space-y-6">
                    <div>
                        <label for="email" class="block text-[13px] font-[700] text-navy mb-2 pl-1">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="w-full px-[16px] py-[12px] bg-white border border-slate-300 rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[15px] font-[600] text-navy placeholder:text-slate-400"
                               value="{{ old('email') }}" placeholder="you@email.com">
                        @error('email')
                            <p class="mt-2 text-[12px] font-[700] text-primary">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2 px-1">
                            <label for="password" class="block text-[13px] font-[700] text-navy">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-[700] text-primary hover:underline">Forgot password?</a>
                            @endif
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="w-full px-[16px] py-[12px] bg-white border border-slate-300 rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[15px] font-[600] text-navy placeholder:text-slate-400"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-[12px] font-[700] text-primary">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-[14px] bg-primary text-white font-[800] rounded-[8px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/10 text-[15px]">
                        Sign In
                    </button>
                </div>
            </form>

            <div class="text-center pt-6 text-[14px] font-[600] text-slate-500">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-primary hover:underline font-[700]">Apply for Admission</a>
            </div>
        </div>
    </div>
</div>
@endsection
