@extends('layouts.app')

@section('title', 'Register - EduLMS')

@section('full_page', true)

@section('content')
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left Side: Gradient & Info (Matches Login) -->
        <div
            class="md:w-7/12 bg-gradient-to-br from-[#232526] via-[#414345] to-[#f37021] relative flex items-center justify-center p-8 overflow-hidden">
            <div class="absolute -top-20 -left-20 opacity-20">
                <svg width="400" height="400" viewBox="0 0 400 400">
                    <circle cx="200" cy="200" r="180" fill="none" stroke="white" stroke-width="1" />
                    <circle cx="200" cy="200" r="140" fill="none" stroke="white" stroke-width="1" />
                    <circle cx="200" cy="200" r="100" fill="none" stroke="white" stroke-width="1" />
                </svg>
            </div>

            <div class="absolute -bottom-20 -right-20 opacity-20">
                <svg width="400" height="400" viewBox="0 0 400 400">
                    <circle cx="200" cy="200" r="180" fill="none" stroke="white" stroke-width="1" />
                    <circle cx="200" cy="200" r="140" fill="none" stroke="white" stroke-width="1" />
                    <circle cx="200" cy="200" r="100" fill="none" stroke="white" stroke-width="1" />
                </svg>
            </div>

            <div class="relative z-10 text-center text-white max-w-lg space-y-8">
                <div class="flex flex-col items-center gap-6">
                    <img src="{{ asset('ace logo.svg') }}" class="h-20 w-auto" alt="The Ace India">
                    <h1 class="text-[48px] font-[900] tracking-tight leading-tight">Join The Ace India</h1>
                </div>
                <p class="text-[18px] font-[500] opacity-90 leading-relaxed">
                    Start your learning journey today and gain access to premium courses from industrial experts.
                </p>

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

    <!-- Right Side: Register Form -->
    <div class="md:w-5/12 bg-white flex items-center justify-center p-8 lg:p-24 overflow-y-auto">
        <div class="w-full max-w-[400px] space-y-8">
            <div>
                <h2 class="text-[32px] font-[800] text-navy">Create Account</h2>
                <p class="text-muted text-[15px] font-[500] mt-1">Join thousands of students on The Ace India</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-[13px] font-[700] text-navy mb-2 pl-1">Full Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" required
                            class="w-full px-[16px] py-[12px] bg-white border border-slate-300 rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[15px] font-[600] text-navy placeholder:text-slate-400"
                            value="{{ old('name') }}" placeholder="John Doe">
                        @error('name')
                            <p class="mt-2 text-[12px] font-[700] text-primary">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-[13px] font-[700] text-navy mb-2 pl-1">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="w-full px-[16px] py-[12px] bg-white border border-slate-300 rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[15px] font-[600] text-navy placeholder:text-slate-400"
                            value="{{ old('email') }}" placeholder="name@example.com">
                        @error('email')
                            <p class="mt-2 text-[12px] font-[700] text-primary">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="whatsapp_number" class="block text-[13px] font-[700] text-navy mb-2 pl-1">WhatsApp Number</label>
                            <input id="whatsapp_number" name="whatsapp_number" type="text" required
                                class="w-full px-[16px] py-[12px] bg-white border border-slate-300 rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[15px] font-[600] text-navy placeholder:text-slate-400"
                                value="{{ old('whatsapp_number') }}" placeholder="+91 98765 43210">
                            @error('whatsapp_number')
                                <p class="mt-2 text-[12px] font-[700] text-primary">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="linkedin_url" class="block text-[13px] font-[700] text-navy mb-2 pl-1">LinkedIn Profile (URL)</label>
                            <input id="linkedin_url" name="linkedin_url" type="url"
                                class="w-full px-[16px] py-[12px] bg-white border border-slate-300 rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[15px] font-[600] text-navy placeholder:text-slate-400"
                                value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/username">
                            @error('linkedin_url')
                                <p class="mt-2 text-[12px] font-[700] text-primary">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-[13px] font-[700] text-navy mb-2 pl-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="w-full px-[16px] py-[12px] bg-white border border-slate-300 rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[15px] font-[600] text-navy placeholder:text-slate-400"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-[12px] font-[700] text-primary">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[13px] font-[700] text-navy mb-2 pl-1">Confirm
                            Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            autocomplete="new-password" required
                            class="w-full px-[16px] py-[12px] bg-white border border-slate-300 rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[15px] font-[600] text-navy placeholder:text-slate-400"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-[14px] bg-navy text-white font-[800] rounded-[8px] hover:bg-primary transition-all shadow-lg shadow-navy/10 text-[15px]">
                        Create My Account
                    </button>
                </div>
            </form>

            <div class="text-center pt-6 text-[14px] font-[600] text-slate-500">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary hover:underline font-[700]">Log In Here</a>
            </div>
        </div>
    </div>
@endsection