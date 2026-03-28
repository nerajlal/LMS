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
        <div class="bg-white rounded-[20px] border border-slate-200 shadow-sm overflow-hidden border-l-4 border-l-navy transition-all hover:shadow-md">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-[12px] bg-navy text-white flex items-center justify-center shadow-lg shadow-navy/10 transform rotate-3">
                        <i class="bi bi-folder-symlink-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-[14px] font-[900] text-navy uppercase tracking-tight leading-none mb-1.5">{{ $branch->name }}</h3>
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest border-r border-slate-200 pr-3">
                                {{ $branch->course->title ?? 'General Batch' }}
                            </span>
                            <span class="text-[10px] text-primary font-[900] uppercase tracking-widest">
                                <i class="bi bi-person-badge"></i> {{ $branch->trainer->name ?? 'System Admin' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-[9px] font-[900] text-slate-400 uppercase tracking-widest bg-white border border-slate-200 px-3 py-1.5 rounded-full shadow-sm">
                        {{ $branch->liveClasses->count() }} Transmissions
                    </div>
                </div>
            </div>
            
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
                                    <form action="{{ route('admin.live-classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Expunge broadcast?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 bg-pink-50 text-pink-600 rounded-[8px] flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all border border-pink-100">
                                            <i class="bi bi-trash-fill text-[12px]"></i>
                                        </button>
                                    </form>
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
                                <form action="{{ route('admin.live-classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Expunge broadcast?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 bg-slate-100 text-slate-400 rounded-[8px] flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all border border-slate-200">
                                        <i class="bi bi-trash-fill text-[12px]"></i>
                                    </button>
                                </form>
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
</div>
@endsection
