@extends(Auth::user()->is_admin || Auth::user()->is_trainer ? 'layouts.admin' : 'layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-10 py-6">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Account & Security</h1>
        <p class="text-slate-500 mt-1 font-medium">Manage your personal information and system preferences</p>
    </div>

    <!-- Profile Information -->
    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-slate-50 rounded-full blur-3xl opacity-50"></div>
        <div class="relative">
            <h3 class="text-lg font-black text-slate-900 mb-8 border-b border-slate-50 pb-6 uppercase tracking-widest text-[10px] text-slate-400">Profile Metadata</h3>
            
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                @csrf @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Primary Identity</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Access Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="px-8 py-4 bg-slate-900 text-white font-black text-xs rounded-xl hover:bg-[#e3000f] transition-all uppercase tracking-widest shadow-lg shadow-slate-900/10">
                        Synchronize Profile
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span class="ml-4 text-[10px] font-black text-emerald-600 uppercase tracking-widest italic animate-pulse">Changes Saved</span>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Password Update -->
    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl">
        <h3 class="text-lg font-black text-slate-900 mb-8 border-b border-slate-50 pb-6 uppercase tracking-widest text-[10px] text-slate-400">Credential Sync</h3>
        
        <form action="{{ route('password.update') }}" method="POST" class="space-y-8">
            @csrf @method('put')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Current Password</label>
                    <input type="password" name="current_password" required 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">New Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Confirm New Credentials</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-8 py-4 bg-slate-900 text-white font-black text-xs rounded-xl hover:bg-[#e3000f] transition-all uppercase tracking-widest shadow-lg shadow-slate-900/10 active:scale-95">
                    Update Credentials
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
