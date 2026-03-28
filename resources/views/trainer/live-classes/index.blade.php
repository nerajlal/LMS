@extends('layouts.admin')

@section('title', 'Live Classes')

@section('content')
<div class="space-y-8">
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-camera-video text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Live Class <span class="text-primary">Batches</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Organize and schedule your sessions by batch</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button onclick="document.getElementById('branchModal').showModal()" class="px-6 py-3.5 bg-primary text-white font-[900] text-[12px] rounded-[12px] hover:bg-orange-600 transition-all flex items-center gap-3 uppercase tracking-widest shadow-xl shadow-orange-500/20">
                    <i class="bi bi-plus-lg text-lg"></i>
                    <span>New Batch</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Branch Sections -->
    <div class="space-y-8">
        @foreach($branches as $branch)
        <div class="bg-white rounded-[20px] border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-border flex justify-between items-center" x-data="{ open: false }">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-[10px] bg-navy text-white flex items-center justify-center">
                        <i class="bi bi-folder2-open"></i>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-[900] text-navy uppercase tracking-tight">{{ $branch->name }}</h3>
                        <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest">{{ $branch->course->title ?? 'General Batch' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest bg-white border border-border px-3 py-1.5 rounded-full">
                        {{ $branch->liveClasses->count() }} Sessions
                    </div>
                    <a href="{{ route('trainer.live-classes.create', ['branch_id' => $branch->id]) }}" class="px-4 py-2 bg-primary text-white text-[10px] font-[900] uppercase tracking-widest rounded-[8px] hover:bg-orange-600 transition-all shadow-sm">
                        <i class="bi bi-plus-lg"></i> Add Live Class
                    </a>
                    
                    <!-- 3-Dot Options Menu -->
                    <div class="relative">
                        <button @click="open = !open" @click.away="open = false" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-200 transition-colors text-slate-400 focus:outline-none">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-48 bg-white border border-border rounded-[12px] shadow-xl z-50 overflow-hidden"
                             style="display: none;">
                            <button @click="$dispatch('open-coupon-modal', { batchId: {{ $branch->id }}, batchName: '{{ $branch->name }}' })" 
                                    class="w-full px-4 py-3 text-left text-[11px] font-[800] text-navy uppercase tracking-widest hover:bg-slate-50 flex items-center gap-3 transition-colors">
                                <i class="bi bi-ticket-perforated-fill text-primary"></i> Add Coupon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-border">
                        @forelse($branch->liveClasses as $class)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="text-[14px] font-[800] text-navy group-hover:text-primary transition-colors leading-tight truncate max-w-[200px]">{{ $class->title }}</div>
                                <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1.5 flex items-center gap-2">
                                    <i class="bi bi-clock text-primary"></i> {{ \Carbon\Carbon::parse($class->start_time)->format('M d, g:i A') }} ({{ $class->duration }})
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <div class="flex items-center gap-2 text-[10px] font-[900] uppercase tracking-widest {{ $class->status === 'live' ? 'text-emerald-600' : 'text-amber-500' }} mr-4">
                                        {{ $class->status }}
                                    </div>
                                    @if($class->isEnded())
                                        <div class="px-4 py-2 bg-slate-100 text-slate-400 rounded-[10px] text-[11px] font-[800] uppercase tracking-widest border border-slate-200 cursor-not-allowed">
                                            Ended <i class="bi bi-clock-history"></i>
                                        </div>
                                    @else
                                        <a href="{{ $class->zoom_link }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-navy rounded-[10px] text-[11px] font-[800] uppercase tracking-widest hover:bg-navy hover:text-white transition-all border border-slate-200">
                                            Join <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center bg-slate-50/20">
                                <p class="text-[12px] text-slate-400 italic font-[600]">No sessions yet in this batch.</p>
                                <a href="{{ route('trainer.live-classes.create', ['branch_id' => $branch->id]) }}" class="mt-3 inline-flex items-center gap-2 text-primary font-[800] text-[11px] uppercase tracking-widest hover:underline">
                                    <i class="bi bi-plus-circle"></i> Create first session
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach

        <!-- Unbranched Classes (Legacy/General) -->
        @if($unbranchedClasses->count() > 0)
        <div class="bg-white rounded-[20px] border border-border shadow-sm overflow-hidden border-dashed border-2">
            <div class="px-6 py-4 bg-slate-50/30 border-b border-border flex justify-between items-center">
                <div class="flex items-center gap-3 opacity-60">
                    <div class="w-10 h-10 rounded-[10px] bg-slate-200 text-slate-500 flex items-center justify-center border border-slate-300">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-[900] text-slate-500 uppercase tracking-tight">Unorganized Sessions</h3>
                        <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest">Legacy or general live classes</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-border">
                        @foreach($unbranchedClasses as $class)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="text-[14px] font-[800] text-slate-500 group-hover:text-primary transition-colors leading-tight truncate max-w-[200px]">{{ $class->title }}</div>
                                <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1.5 flex items-center gap-2">
                                    <i class="bi bi-clock text-slate-300"></i> {{ \Carbon\Carbon::parse($class->start_time)->format('M d, g:i A') }}
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                @if($class->isEnded())
                                    <div class="px-4 py-2 bg-slate-50 text-slate-300 rounded-[10px] text-[11px] font-[800] uppercase tracking-widest border border-slate-100 italic">
                                        Ended
                                    </div>
                                @else
                                    <a href="{{ $class->zoom_link }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-400 rounded-[10px] text-[11px] font-[800] uppercase tracking-widest hover:bg-navy hover:text-white transition-all border border-slate-200">
                                        Join <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($branches->isEmpty() && $unbranchedClasses->isEmpty())
        <div class="bg-white rounded-[20px] border-2 border-dashed border-border p-20 text-center">
            <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mx-auto mb-6">
                <i class="bi bi-collection-play text-4xl"></i>
            </div>
            <h3 class="text-xl font-[900] text-navy uppercase tracking-tight mb-2">Build your first batch</h3>
            <p class="text-slate-500 text-[14px] max-w-sm mx-auto mb-10">Create a batch to group your live sessions. It helps you and your students stay organized.</p>
            <button onclick="document.getElementById('branchModal').showModal()" class="px-8 py-4 bg-navy text-white font-[900] text-[13px] rounded-[16px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20">
                Create Your First Batch
            </button>
        </div>
        @endif
    </div>

    <!-- Create Branch Modal -->
    <dialog id="branchModal" class="p-0 rounded-[24px] shadow-2xl border-none backdrop:backdrop-blur-sm">
        <div class="w-[450px] bg-white">
            <div class="p-8 border-b border-border bg-slate-50/50">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Create New <span class="text-primary">Batch</span></h3>
                    <button onclick="document.getElementById('branchModal').close()" class="text-slate-400 hover:text-navy transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest">Group your live classes for a specific cohort</p>
            </div>
            
            <form action="{{ route('trainer.live-classes.branches.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Batch Name</label>
                    <input type="text" name="name" required placeholder="e.g. Batch A - Morning" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy placeholder:text-slate-300 italic">
                </div>
                
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Related Course (Optional)</label>
                    <div class="relative">
                        <select name="course_id" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy appearance-none cursor-pointer">
                            <option value="">General Branch</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-navy/30 pointer-events-none"></i>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-navy text-white rounded-[14px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20 active:scale-[0.98]">
                        Create Batch
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Coupon Modal -->
    <dialog id="couponModal" class="p-0 rounded-[24px] shadow-2xl border-none backdrop:backdrop-blur-sm"
            x-data="{ batchId: '', batchName: '' }"
            @open-coupon-modal.window="batchId = $event.detail.batchId; batchName = $event.detail.batchName; $el.showModal()">
        <div class="w-[450px] bg-white">
            <div class="p-8 border-b border-border bg-slate-50/50">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Generate <span class="text-primary">Coupon</span></h3>
                    <button @click="$el.closest('dialog').close()" class="text-slate-400 hover:text-navy transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest">Single-use discount for <span class="text-navy" x-text="batchName"></span></p>
            </div>
            
            <form action="{{ route('trainer.live-classes.coupons.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="batch_id" :value="batchId">
                
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Coupon Code</label>
                    <div class="relative group">
                        <input type="text" name="code" id="coupon_code" required placeholder="e.g. SAVE500" 
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[900] text-navy placeholder:text-slate-300 tracking-widest uppercase">
                        <button type="button" @click="document.getElementById('coupon_code').value = 'CPN' + Math.random().toString(36).substring(2, 8).toUpperCase()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-primary font-[900] text-[10px] uppercase tracking-widest hover:scale-105 transition-transform">
                            Generate
                        </button>
                    </div>
                </div>
                
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Discount Amount (Fixed ₹)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-navy/30 font-[900]">₹</span>
                        <input type="number" name="discount_amount" required placeholder="500" 
                               class="w-full pl-10 pr-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[900] text-navy placeholder:text-slate-300">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-navy text-white rounded-[14px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20 active:scale-[0.98]">
                        Activate Coupon
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</div>
@endsection
