@extends(auth()->user()->is_admin || auth()->user()->is_trainer ? 'layouts.admin' : 'layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-6">
    <div>
        <h1 class="text-[24px] font-[800] text-navy tracking-tight">Account & Security</h1>
        <p class="text-muted mt-1 font-[500] text-[14px]">Manage your personal information and system preferences</p>
    </div>

    <!-- Profile Information -->
    <div class="bg-white p-[32px] rounded-[12px] border border-border shadow-sm relative overflow-hidden">
        <div class="relative">
            <h3 class="text-[12px] font-[700] text-muted uppercase tracking-widest mb-[24px] border-b border-border pb-[16px]">Profile Metadata</h3>
            
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-[24px]">
                    <div>
                        <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-[8px] pl-1">Primary Identity</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required 
                               class="w-full px-[16px] py-[12px] bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                    </div>
                    <div>
                        <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-[8px] pl-1">Access Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required 
                               class="w-full px-[16px] py-[12px] bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                    </div>
                </div>

                <div class="pt-[16px]">
                    <button type="submit" class="px-[24px] py-[12px] bg-navy text-white font-[700] text-[14px] rounded-[8px] hover:bg-primary transition-all uppercase tracking-wider shadow-sm">
                        Synchronize Profile
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span class="ml-4 text-[12px] font-[700] text-emerald-600 uppercase tracking-widest animate-pulse">Changes Saved</span>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Password Update -->
    <div class="bg-white p-[32px] rounded-[12px] border border-border shadow-sm">
        <h3 class="text-[12px] font-[700] text-muted uppercase tracking-widest mb-[24px] border-b border-border pb-[16px]">Credential Sync</h3>
        
        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf @method('put')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-[24px]">
                <div class="md:col-span-2">
                    <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-[8px] pl-1">Current Password</label>
                    <input type="password" name="current_password" required 
                           class="w-full px-[16px] py-[12px] bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                </div>
                <div>
                    <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-[8px] pl-1">New Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-[16px] py-[12px] bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                </div>
                <div>
                    <label class="block text-[12px] font-[700] text-navy uppercase tracking-wider mb-[8px] pl-1">Confirm New Credentials</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full px-[16px] py-[12px] bg-white border border-border rounded-[8px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                </div>
            </div>

            <div class="pt-[16px]">
                <button type="submit" class="px-[24px] py-[12px] bg-navy text-white font-[700] text-[14px] rounded-[8px] hover:bg-primary transition-all uppercase tracking-wider shadow-sm">
                    Update Credentials
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
