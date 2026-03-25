@extends('layouts.app')

@section('title', 'Log In - The Ace India')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-50 rounded-full blur-2xl opacity-50"></div>
        
        <div class="text-center relative">
            <div class="w-16 h-16 bg-[#e3000f] rounded-2xl flex items-center justify-center text-white text-3xl font-black mx-auto mb-6 shadow-lg shadow-red-500/20">A</div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Welcome Back</h2>
            <p class="mt-2 text-sm text-slate-500 font-medium italic">Please enter your details to access your dashboard</p>
        </div>

        @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded-xl text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-widest pl-1 mb-2">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e3000f]/20 focus:border-[#e3000f] sm:text-sm font-semibold transition-all"
                           value="{{ old('email') }}" placeholder="name@example.com">
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-[#e3000f]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-widest pl-1 mb-2">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="appearance-none relative block w-full px-4 py-3 border border-slate-200 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e3000f]/20 focus:border-[#e3000f] sm:text-sm font-semibold transition-all"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-xs font-bold text-[#e3000f]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between px-1">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-[#e3000f] focus:ring-[#e3000f] border-slate-300 rounded cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-xs font-bold text-slate-500 uppercase tracking-widest cursor-pointer">Remember me</label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-xs">
                        <a href="{{ route('password.request') }}" class="font-bold text-[#e3000f] hover:underline uppercase tracking-widest">Forgot password?</a>
                    </div>
                @endif
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-black rounded-xl text-white bg-[#e3000f] hover:bg-[#cc0000] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e3000f] transition-all transform hover:-translate-y-0.5 shadow-lg shadow-red-500/20 uppercase tracking-widest">
                    Log In to Dashboard
                </button>
            </div>
        </form>

        <div class="text-center pt-4">
            <p class="text-sm text-slate-500 font-medium">Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-[#e3000f] hover:underline">Register Now</a>
            </p>
        </div>
    </div>
</div>
@endsection
