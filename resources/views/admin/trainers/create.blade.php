@extends('layouts.admin')

@section('title', 'Onboard Instructor')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <div class="bg-white p-10 lg:p-14 rounded-[3rem] border border-slate-200 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
        
        <div class="mb-12 relative flex items-center justify-between">
            <div>
                <div class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 pl-1">HR & Operations</div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Onboard Instructor</h1>
                <p class="text-sm text-slate-500 font-medium italic mt-2">Initialize access for a new educator on the platform.</p>
            </div>
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-3xl">
                <i class="bi bi-person-workspace"></i>
            </div>
        </div>

        <form action="{{ route('admin.trainers.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Full Name</label>
                    <input type="text" name="name" required placeholder="Instructor Name" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600/20 focus:bg-white transition-all text-sm font-bold">
                    @error('name') <p class="mt-2 text-xs font-bold text-orange-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Professional Email</label>
                    <input type="email" name="email" required placeholder="instructor@theaceindia.com" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600/20 focus:bg-white transition-all text-sm font-bold">
                    @error('email') <p class="mt-2 text-xs font-bold text-orange-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Access Password</label>
                        <input type="password" name="password" required 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600/20 focus:bg-white transition-all text-sm font-bold">
                        @error('password') <p class="mt-2 text-xs font-bold text-orange-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Confirm Access</label>
                        <input type="password" name="password_confirmation" required 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600/20 focus:bg-white transition-all text-sm font-bold">
                    </div>
                </div>
            </div>

            <div class="pt-8">
                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-slate-900/10 active:scale-95 transform">
                    Issue Instructor Credentials
                </button>
                <div class="mt-6 flex items-center justify-center gap-2 text-slate-400 italic text-xs font-medium uppercase tracking-widest">
                    <i class="bi bi-shield-check text-base text-blue-600"></i>
                    Role: TRAINER (Restricted Admin Access)
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
