@extends('layouts.app')

@section('title', 'Register - The Ace India')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-50 rounded-full blur-2xl opacity-50"></div>
        
        <div class="text-center relative">
            <div class="w-16 h-16 bg-[#F37021] rounded-2xl flex items-center justify-center text-white text-3xl font-black mx-auto mb-6 shadow-lg shadow-orange-500/20">A</div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Create Account</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium italic">Join thousands of students on The Ace India</p>
        </div>

        <form class="mt-8 space-y-5" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest pl-1 mb-1.5">Full Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F37021]/20 focus:border-[#F37021] sm:text-sm font-semibold transition-all"
                           value="{{ old('name') }}" placeholder="John Doe">
                    @error('name')
                        <p class="mt-2 text-xs font-bold text-[#F37021]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-widest pl-1 mb-1.5">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F37021]/20 focus:border-[#F37021] sm:text-sm font-semibold transition-all"
                           value="{{ old('email') }}" placeholder="name@example.com">
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-[#F37021]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-widest pl-1 mb-1.5">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F37021]/20 focus:border-[#F37021] sm:text-sm font-semibold transition-all"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-xs font-bold text-[#F37021]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-400 uppercase tracking-widest pl-1 mb-1.5">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F37021]/20 focus:border-[#F37021] sm:text-sm font-semibold transition-all"
                           placeholder="••••••••">
                    @error('password_confirmation')
                        <p class="mt-2 text-xs font-bold text-[#F37021]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-black rounded-xl text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-slate-900/20 uppercase tracking-widest">
                    Create My Account
                </button>
            </div>
        </form>

        <div class="text-center pt-4">
            <p class="text-sm text-slate-500 font-medium">Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-[#F37021] hover:underline">Log In Here</a>
            </p>
        </div>
    </div>
</div>
@endsection
