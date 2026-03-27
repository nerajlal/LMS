@extends(auth()->user()->is_admin || auth()->user()->is_trainer ? 'layouts.admin' : 'layouts.app')

@section('title', 'Account & Security - The Ace India')

@section('content')
<div class="space-y-8" x-data="{ activeTab: 'profile' }">
    <!-- Premium Identity Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-[16px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-shield-lock text-primary text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight">Account & <span class="text-primary">Security</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Manage your digital identity</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="px-4 py-2 bg-white/5 border border-white/10 rounded-full flex items-center gap-3 backdrop-blur-md">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                    <span class="text-[11px] font-[800] uppercase tracking-widest text-slate-300">System Secure</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Sidebar: Identity Card -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[16px] border border-border shadow-sm overflow-hidden group">
                <div class="h-24 bg-navy relative">
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2">
                        <div class="w-20 h-20 rounded-[20px] bg-white p-1.5 shadow-xl">
                            <div class="w-full h-full rounded-[16px] bg-slate-100 flex items-center justify-center text-navy text-3xl font-[900] uppercase">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-14 pb-8 px-8 text-center">
                    <h3 class="text-xl font-[800] text-navy">{{ auth()->user()->name }}</h3>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-[900] uppercase tracking-widest rounded-full">
                            @if(auth()->user()->is_admin) Admin @elseif(auth()->user()->is_trainer) trainer @else Student @endif
                        </span>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-slate-50 space-y-4">
                        <div class="flex items-center justify-between text-[13px]">
                            <span class="font-[600] text-muted">Join Date</span>
                            <span class="font-[700] text-navy">{{ auth()->user()->created_at?->format('F d, Y') ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[13px]">
                            <span class="font-[600] text-muted">Status</span>
                            <span class="text-emerald-500 font-[800] uppercase text-[10px] tracking-widest flex items-center gap-1.5">
                                <i class="bi bi-patch-check-fill"></i> Verified
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Navigation Tips -->
            <div class="p-6 bg-slate-50 rounded-[16px] border border-border/50">
                <h4 class="text-[11px] font-[900] text-navy uppercase tracking-widest mb-4">Security Tip</h4>
                <p class="text-[13px] text-muted font-[500] leading-relaxed italic">
                    "Use a unique password and enable two-factor authentication if available to protect your learning progress."
                </p>
            </div>
        </div>

        <!-- Main Content: Forms -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Profile Information Card -->
            <div class="bg-white rounded-[16px] border border-border shadow-sm overflow-hidden group hover:border-primary/20 transition-all">
                <div class="px-5 md:px-8 py-4 md:py-5 bg-slate-50/50 border-b border-border flex items-center justify-between">
                    <h3 class="text-[12px] md:text-[14px] font-[800] text-navy uppercase tracking-wider">Profile Information</h3>
                    <i class="bi bi-person-circle text-primary text-lg md:text-xl"></i>
                </div>
                <div class="p-5 md:p-8">
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-[11px] font-[800] text-muted uppercase tracking-widest pl-1">Full Identity Name</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required 
                                       class="w-full px-5 py-3.5 bg-slate-50 border border-border rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-[800] text-muted uppercase tracking-widest pl-1">Email Access Point</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required 
                                       class="w-full px-5 py-3.5 bg-slate-50 border border-border rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy">
                            </div>
                        </div>

                        <div class="pt-4 flex items-center gap-6">
                            <button type="submit" class="px-8 py-3.5 bg-navy text-white font-[800] text-[12px] rounded-[12px] hover:bg-primary transition-all uppercase tracking-widest shadow-xl shadow-navy/10 flex items-center gap-2">
                                <i class="bi bi-arrow-repeat"></i> Synchronize Data
                            </button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-[11px] font-[800] text-emerald-600 uppercase tracking-widest animate-pulse">Data Secured Successfully</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="bg-white rounded-[16px] border border-border shadow-sm overflow-hidden group hover:border-primary/20 transition-all">
                <div class="px-5 md:px-8 py-4 md:py-5 bg-slate-50/50 border-b border-border flex items-center justify-between">
                    <h3 class="text-[12px] md:text-[14px] font-[800] text-navy uppercase tracking-wider">Credential Synchronization</h3>
                    <i class="bi bi-key text-primary text-lg md:text-xl"></i>
                </div>
                <div class="p-5 md:p-8">
                    <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                        @csrf @method('put')
                        
                        <div class="space-y-2">
                            <label class="block text-[11px] font-[800] text-muted uppercase tracking-widest pl-1">Current Master Key</label>
                            <input type="password" name="current_password" required 
                                   class="w-full px-5 py-3.5 bg-slate-50 border border-border rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy"
                                   placeholder="••••••••">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-[11px] font-[800] text-muted uppercase tracking-widest pl-1">New Credential Key</label>
                                <input type="password" name="password" required 
                                       class="w-full px-5 py-3.5 bg-slate-50 border border-border rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy"
                                       placeholder="••••••••">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[11px] font-[800] text-muted uppercase tracking-widest pl-1">Verify New Key</label>
                                <input type="password" name="password_confirmation" required 
                                       class="w-full px-5 py-3.5 bg-slate-50 border border-border rounded-[12px] focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-[14px] font-[600] text-navy"
                                       placeholder="••••••••">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="px-8 py-3.5 bg-navy text-white font-[800] text-[12px] rounded-[12px] hover:bg-primary transition-all uppercase tracking-widest shadow-xl shadow-navy/10 flex items-center gap-2">
                                <i class="bi bi-shield-check"></i> Update Credentials
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
