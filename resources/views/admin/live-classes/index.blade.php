@extends('layouts.admin')

@section('title', 'Manage Live Classes - Admin')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-camera-video text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase leading-none">Broadcasting <span class="text-primary">Control</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-2">Monitor and manage all interactive sessions</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-[16px] backdrop-blur-sm">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></div>
                <span class="text-[10px] font-[800] text-slate-300 uppercase tracking-widest">Streaming Node Sync Active</span>
            </div>
        </div>
    </div>

    <!-- Batch Sections -->
    <div class="space-y-8">
        @foreach($branches as $branch)
        <div class="bg-white rounded-[20px] border border-slate-200 shadow-sm border-l-4 border-l-navy transition-all hover:shadow-md" 
             x-data="{ expanded: false, menuOpen: false }"
             :class="{ 'overflow-visible z-[100] relative': menuOpen, 'overflow-hidden': !menuOpen }">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center select-none group/header">
                <!-- Expansion Click Target (Left Side) -->
                <div @click="expanded = !expanded" class="flex items-center gap-4 cursor-pointer flex-1 py-1">
                    <div class="w-10 h-10 rounded-[12px] bg-navy text-white flex items-center justify-center shadow-lg shadow-navy/10 transform transition-transform group-hover/header:rotate-6">
                        <i class="bi bi-folder-symlink-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-[14px] font-[900] text-navy uppercase tracking-tight leading-none mb-1.5">{{ $branch->name }}</h3>
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest border-r border-slate-200 pr-3">
                                {{ $branch->course->title ?? 'General Batch' }}
                            </span>
                            <span class="text-[10px] text-primary font-[900] uppercase tracking-widest flex items-center gap-1.5">
                                <i class="bi bi-person-badge"></i> 
                                <span class="truncate max-w-[150px]">
                                    {{ $branch->trainers->count() > 0 ? $branch->trainers->pluck('name')->join(', ') : 'No Tutors Assigned' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tools & Interactive Elements (Right Side) -->
                <div class="flex items-center gap-4">
                    <div class="text-[9px] font-[900] text-slate-400 uppercase tracking-widest bg-white border border-slate-200 px-3 py-1.5 rounded-full shadow-sm">
                        {{ $branch->liveClasses->count() }} Sessions
                    </div>
                    
                    <!-- 3-Dot Options Menu (Unified x-data) -->
                    <div class="relative">
                        <button @click="menuOpen = !menuOpen" @click.away="menuOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-navy/10 transition-colors text-slate-400 focus:outline-none relative z-[60]">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <div x-show="menuOpen" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-[12px] shadow-xl z-[70] overflow-hidden"
                             style="display: none;"
                             x-cloak>
                            <button @click="menuOpen = false; $dispatch('open-coupon-modal', { batchId: {{ $branch->id }}, batchName: '{{ $branch->name }}' })" 
                                    class="w-full px-4 py-3 text-left text-[10px] font-[900] text-navy uppercase tracking-[0.1em] hover:bg-slate-50 flex items-center gap-3 transition-colors">
                                <i class="bi bi-ticket-perforated-fill text-primary text-[14px]"></i> Add Coupon
                            </button>
                            <button @click="menuOpen = false; $dispatch('open-tutor-modal', { batchId: {{ $branch->id }}, batchName: '{{ $branch->name }}' })" 
                                    class="w-full px-4 py-3 text-left text-[10px] font-[900] text-navy uppercase tracking-[0.1em] hover:bg-slate-50 flex items-center gap-3 transition-colors border-t border-slate-50">
                                <i class="bi bi-person-plus-fill text-primary text-[14px]"></i> Add Tutor
                            </button>
                        </div>
                    </div>

                    <!-- Chevron Toggle (Expansion Target) -->
                    <div @click="expanded = !expanded" class="w-8 h-8 rounded-full bg-navy/5 flex items-center justify-center text-navy/40 transition-transform duration-300 cursor-pointer hover:bg-navy hover:text-white" :class="{ 'rotate-180 bg-navy text-white': expanded }">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
            </div>
            
            <div x-show="expanded" x-collapse x-cloak>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-50">
                            @forelse($branch->liveClasses as $class)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div @class([
                                            'w-8 h-8 rounded-[8px] flex items-center justify-center text-sm shrink-0 border shadow-sm',
                                            'bg-emerald-50 text-emerald-600 border-emerald-100' => $class->status === 'live',
                                            'bg-amber-50 text-amber-600 border-amber-100' => $class->status === 'upcoming',
                                            'bg-slate-50 text-slate-400 border-slate-100' => $class->status === 'completed',
                                        ])>
                                            <i @class([
                                                'bi',
                                                'bi-broadcast animate-pulse' => $class->status === 'live',
                                                'bi-calendar-event' => $class->status === 'upcoming',
                                                'bi-check-circle' => $class->status === 'completed',
                                            ])></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-[13px] font-[800] text-navy truncate group-hover:text-primary transition-colors">{{ $class->title }}</div>
                                            <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1 flex items-center gap-2">
                                                <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($class->start_time)->format('M d, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span @class([
                                        'px-2 py-0.5 rounded-full text-[8px] font-[900] uppercase tracking-widest shadow-sm border',
                                        'bg-emerald-500 text-white border-emerald-400' => $class->status === 'live',
                                        'bg-amber-100 text-amber-600 border-amber-200' => $class->status === 'upcoming',
                                        'bg-slate-100 text-slate-500 border-slate-200' => $class->status === 'completed',
                                    ])>
                                        {{ $class->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ $class->zoom_link }}" target="_blank" class="w-8 h-8 bg-slate-50 text-slate-400 rounded-[8px] flex items-center justify-center hover:bg-navy hover:text-white transition-all border border-slate-100 shadow-sm" title="Session Node">
                                            <i class="bi bi-link-45deg text-lg"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center bg-slate-50/10">
                                    <p class="text-[11px] text-slate-400 font-[600] italic">No active nodes in this batch.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Unbranched Classes -->
        @if($unbranchedClasses->count() > 0)
        <div class="bg-white rounded-[20px] border border-slate-200 shadow-sm overflow-hidden border-dashed border-2">
            <div class="px-6 py-4 bg-slate-50/30 border-b border-slate-100 flex justify-between items-center opacity-60 grayscale-[0.5]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-[10px] bg-slate-200 text-slate-500 flex items-center justify-center border border-slate-300">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div>
                        <h3 class="text-[14px] font-[900] text-slate-500 uppercase tracking-tight leading-none mb-1.5">Unorganized Transmissions</h3>
                        <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest italic">Legacy or unbranched session nodes</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-slate-50">
                        @foreach($unbranchedClasses as $class)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="text-[13px] font-[800] text-slate-500 group-hover:text-primary transition-colors">{{ $class->title }}</div>
                                <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1 italic">
                                    Trainer: {{ $class->instructor_name }}
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ $class->zoom_link }}" target="_blank" class="w-8 h-8 bg-slate-50 text-slate-400 rounded-[8px] flex items-center justify-center hover:bg-navy hover:text-white transition-all border border-slate-100 shadow-sm" title="Session Node">
                                    <i class="bi bi-link-45deg text-lg"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($branches->isEmpty() && $unbranchedClasses->isEmpty())
        <div class="bg-white rounded-[20px] border-2 border-dashed border-slate-200 p-20 text-center">
            <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mx-auto mb-6">
                <i class="bi bi-camera-video-off text-4xl"></i>
            </div>
            <h3 class="text-xl font-[900] text-navy uppercase tracking-tight mb-2">No transmissions found</h3>
            <p class="text-slate-500 text-[14px] max-w-sm mx-auto">All interactive sessions will appear here once trainers define their batches.</p>
        </div>
        @endif
    </div>

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
            
            <form action="{{ route('admin.live-classes.coupons.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="batch_id" :value="batchId">
                
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Coupon Code</label>
                    <div class="relative group">
                        <input type="text" name="code" id="coupon_code" required placeholder="e.g. SAVE500" 
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[900] text-navy placeholder:text-slate-300 tracking-widest uppercase outline-none">
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
                               class="w-full pl-10 pr-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[900] text-navy placeholder:text-slate-300 outline-none">
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

    <!-- Assign Tutor Modal -->
    <dialog id="tutorModal" class="p-0 rounded-[24px] shadow-2xl border-none backdrop:backdrop-blur-sm"
            x-data="{ batchId: '', batchName: '', trainerId: '' }"
            @open-tutor-modal.window="batchId = $event.detail.batchId; batchName = $event.detail.batchName; trainerId = $event.detail.currentTrainerId; $el.showModal()">
        <div class="w-[450px] bg-white">
            <div class="p-8 border-b border-border bg-slate-50/50">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Assign <span class="text-primary">Tutor</span></h3>
                    <button @click="$el.closest('dialog').close()" class="text-slate-400 hover:text-navy transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest">Delegating authority for <span class="text-navy" x-text="batchName"></span></p>
            </div>
            
            <form :action="'{{ url('/admin/live-classes/batches') }}/' + batchId + '/trainer'" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Select Specialized Trainer</label>
                    <div class="relative">
                        <select name="trainer_id" x-model="trainerId" required
                                class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[13px] font-[800] text-navy appearance-none outline-none">
                            <option value="">Select a Trainer</option>
                            @foreach($trainers as $trainer)
                                <option value="{{ $trainer->id }}">{{ $trainer->name }} ({{ $trainer->email }})</option>
                            @endforeach
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-navy text-white rounded-[14px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20 active:scale-[0.98]">
                        Confirm Delegation
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</div>
@endsection
