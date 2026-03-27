@extends('layouts.admin')

@section('title', 'Onboard Instructor')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-person-workspace text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase leading-none">Instructor <span class="text-primary">Onboarding</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-2">Initialize access for a new educator</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-[16px] backdrop-blur-sm">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></div>
                <span class="text-[10px] font-[800] text-slate-300 uppercase tracking-widest">Secure Credentialing</span>
            </div>
        </div>
    </div>

    <!-- Form Console -->
    <div class="bg-white rounded-[24px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden relative group">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-50 rounded-full blur-3xl opacity-30 group-hover:scale-150 transition-transform duration-1000"></div>
        
        <form action="{{ route('admin.trainers.store') }}" method="POST" class="p-8 md:p-12 relative z-10 space-y-10">
            @csrf
            
            <div class="space-y-8">
                <!-- Profile Identity -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Full Legal Name</label>
                        <div class="relative">
                            <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="name" required placeholder="Instructor Name" 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                        @error('name') <p class="mt-2 text-[10px] font-black text-primary uppercase tracking-widest pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Professional Email</label>
                        <div class="relative">
                            <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="email" name="email" required placeholder="instructor@theaceindia.com" 
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                        @error('email') <p class="mt-2 text-[10px] font-black text-primary uppercase tracking-widest pl-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Access Control -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Access Password</label>
                        <div class="relative">
                            <i class="bi bi-shield-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="password" name="password" required placeholder="••••••••"
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                        @error('password') <p class="mt-2 text-[10px] font-black text-primary uppercase tracking-widest pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-[900] text-navy uppercase tracking-widest pl-1">Confirm Access</label>
                        <div class="relative">
                            <i class="bi bi-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="password" name="password_confirmation" required placeholder="••••••••"
                                   class="w-full pl-11 pr-5 py-4 bg-slate-50 border border-slate-100 rounded-[14px] focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary transition-all text-[14px] font-[700] text-navy outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Section -->
            <div class="pt-8 flex flex-col items-center border-t border-slate-50">
                <button type="submit" class="w-full md:w-auto px-12 py-5 bg-navy text-white rounded-[16px] font-[900] text-[12px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/10 active:scale-95 transform flex items-center justify-center gap-3">
                    <i class="bi bi-key-fill text-lg"></i>
                    Issue Instructor Credentials
                </button>
                <div class="mt-8 flex items-center justify-center gap-3 text-slate-400 font-[800] text-[10px] uppercase tracking-[0.15em] bg-slate-50 px-6 py-3 rounded-full border border-slate-100 shadow-inner">
                    <i class="bi bi-shield-shaded text-primary text-base"></i>
                    Verification Protocol Active &bull; Role: TRAINER
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
