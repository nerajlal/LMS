@extends('layouts.admin')

@section('title', 'Instructors')

@section('content')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 20px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<div class="space-y-8" x-data="{ 
    trainerDetail: null,
    loading: false,
    async fetchTrainer(name) {
        this.loading = true;
        this.trainerDetail = null;
        try {
            const resp = await fetch(`/admin/api/trainers/courses?name=${encodeURIComponent(name)}`);
            this.trainerDetail = await resp.json();
        } catch(e) { console.error(e); }
        this.loading = false;
    }
}">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-person-badge text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Trainer <span class="text-primary">Directory</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Manage the platform's core educators</p>
                </div>
            </div>
            <a href="{{ route('admin.trainers.create') }}" class="px-6 py-3.5 bg-primary text-white font-[900] text-[12px] rounded-[12px] hover:bg-orange-600 transition-all flex items-center gap-3 uppercase tracking-widest shadow-xl shadow-orange-500/20">
                <i class="bi bi-person-plus-fill text-lg"></i>
                <span>Onboard Trainer</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full scrollbar-hide focus:outline-none">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Instructor Identity</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden md:table-cell">Contact Details</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden sm:table-cell">Privileges</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden lg:table-cell">Joined</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($trainers as $trainer)
                        <tr class="hover:bg-slate-50/30 transition-colors group {{ !$trainer->is_active ? 'opacity-75 grayscale-[0.5]' : '' }}">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-[12px] {{ $trainer->is_active ? 'bg-navy/5 text-navy' : 'bg-slate-200 text-slate-400' }} flex items-center justify-center font-[900] text-sm border border-slate-200 shadow-sm group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all">
                                        {{ substr($trainer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <button @click="fetchTrainer('{{ addslashes($trainer->name) }}')" class="text-[14px] font-[800] text-navy leading-tight mb-1 group-hover:text-primary transition-colors uppercase leading-none text-left hover:underline underline-offset-4 decoration-2">{{ $trainer->name }}</button>
                                        <div class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest mt-1 italic">{{ $trainer->is_active ? 'Active Educator' : 'Account Frozen' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 hidden md:table-cell">
                                <div class="text-[13px] font-[600] text-slate-500">{{ $trainer->email }}</div>
                            </td>
                            <td class="px-6 py-5 hidden sm:table-cell">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-[6px] text-[10px] font-[900] uppercase tracking-widest border border-slate-200 group-hover:bg-primary/5 group-hover:text-primary group-hover:border-primary/20 transition-all">
                                    Lead Instructor
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-2.5 py-1 {{ $trainer->is_active ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }} rounded-lg text-[9px] font-[900] uppercase tracking-widest border shadow-sm">
                                    {{ $trainer->is_active ? 'Authorized' : 'Suspended' }}
                                </span>
                            </td>
                            <td class="px-6 py-5 hidden lg:table-cell text-[11px] font-[800] text-slate-400 uppercase tracking-widest">
                                {{ $trainer->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.trainers.toggle-status', $trainer->id) }}" method="POST" onsubmit="return confirm('Change status for this instructor?')">
                                        @csrf
                                        <button type="submit" class="w-[32px] h-[32px] {{ $trainer->is_active ? 'bg-amber-50 text-amber-500 hover:bg-amber-500' : 'bg-emerald-50 text-emerald-500 hover:bg-emerald-500' }} rounded-[8px] flex items-center justify-center hover:text-white transition-all shadow-sm border border-slate-200" title="{{ $trainer->is_active ? 'Freeze Account' : 'Activate Account' }}">
                                            <i class="bi {{ $trainer->is_active ? 'bi-snow' : 'bi-fire' }} text-[16px]"></i>
                                        </button>
                                    </form>
                                    <button class="w-[32px] h-[32px] bg-slate-50 text-slate-400 rounded-[8px] flex items-center justify-center hover:bg-navy hover:text-white transition-all shadow-sm border border-slate-200" title="Quick Insights" @click="fetchTrainer('{{ addslashes($trainer->name) }}')">
                                        <i class="bi bi-eye text-[16px]"></i>
                                    </button>
                                    <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST" onsubmit="return confirm('Permanently purge this instructor account? This action is irreversible.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-[32px] h-[32px] bg-red-50 text-red-500 rounded-[8px] flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-100" title="Delete Account">
                                            <i class="bi bi-trash3 text-[16px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-400 italic font-bold uppercase tracking-[0.2em] text-[10px]">Registry Protocol: Zero Trainers Detected</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($trainers->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $trainers->links() }}
        </div>
        @endif
    </div>

    <!-- Trainer Catalog Modal -->
    <template x-if="trainerDetail || loading">
        <div class="fixed inset-0 z-[1100] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-navy/80 backdrop-blur-md" @click="trainerDetail = null; loading = false"></div>
            
            <div class="relative bg-white w-full max-w-2xl rounded-[24px] overflow-hidden shadow-2xl border border-white/10 animate-in fade-in zoom-in duration-300 max-h-[90vh] flex flex-col">
                <div class="overflow-y-auto custom-scrollbar flex-1">
                    <!-- Loading State -->
                    <div x-show="loading" class="p-20 text-center">
                        <div class="inline-block w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                        <p class="mt-4 text-[11px] font-[900] text-navy uppercase tracking-widest animate-pulse">Synchronizing Instructor Data...</p>
                    </div>

                    <!-- Trainer Catalog Content -->
                    <div x-show="trainerDetail && !loading" class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-navy text-white flex items-center justify-center text-xl font-[900] shadow-xl">
                                    <span x-text="trainerDetail?.trainer?.substring(0,1)"></span>
                                </div>
                                <div>
                                    <h2 class="text-xl font-[900] text-navy uppercase leading-none" x-text="trainerDetail?.trainer"></h2>
                                    <p class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest mt-2 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                                        Platform Educator Portfolio
                                    </p>
                                </div>
                            </div>
                            <button @click="trainerDetail = null" class="w-10 h-10 bg-slate-50 text-navy rounded-full flex items-center justify-center hover:bg-slate-100 transition-all border border-slate-100">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <h4 class="text-[11px] font-[900] text-navy uppercase tracking-[0.2em] mb-4 flex items-center justify-between">
                                Published Course Catalog 
                                <span class="text-primary" x-text="trainerDetail?.courses?.length + ' Items'"></span>
                            </h4>
                            
                            <div class="space-y-3">
                                <template x-for="course in trainerDetail?.courses" :key="course.id">
                                    <div class="p-4 bg-slate-50 rounded-[16px] border border-slate-100 flex items-center justify-between group hover:bg-white hover:border-primary/20 transition-all cursor-default">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-navy font-[900] text-xs shadow-sm border border-slate-100 group-hover:bg-navy group-hover:text-white transition-all" x-text="course.lessons"></div>
                                            <div>
                                                <div class="text-sm font-[800] text-navy truncate max-w-[200px]" x-text="course.title"></div>
                                                <div class="text-[9px] text-slate-400 font-[700] uppercase tracking-widest mt-0.5" x-text="'PHY-'+course.id.toString().padStart(4, '0')"></div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[13px] font-[900] text-navy" x-text="'₹'+course.price"></div>
                                            <div class="text-[8px] text-emerald-500 font-[900] uppercase tracking-widest">Active</div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-50">
                            <div class="flex items-center justify-between text-[11px] font-[800] text-slate-400 uppercase tracking-widest">
                                <span>Portfolio Market Valuation</span>
                                <span class="text-navy" x-text="'₹'+trainerDetail?.courses?.reduce((acc, c) => acc + parseFloat(c.price.replace(/,/g, '')), 0).toLocaleString()"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection
