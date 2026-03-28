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

    <!-- Data Table Console -->
    <div class="bg-white rounded-[20px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden">
        <div class="overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest">Session Details</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest hidden lg:table-cell">Target Course</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest hidden md:table-cell">Schedule</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest">Status</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($liveClasses as $class)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div @class([
                                    'w-10 h-10 rounded-[10px] flex items-center justify-center text-lg shrink-0 border shadow-sm',
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
                                    <div class="text-[13px] font-[800] text-navy truncate break-all group-hover:text-primary transition-colors max-w-[150px] md:max-w-xs">{{ $class->title }}</div>
                                    <div class="text-[11px] text-slate-500 font-[600] italic mt-0.5 truncate">{{ $class->instructor_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 hidden lg:table-cell">
                            <span class="text-[13px] font-[700] text-slate-600 truncate max-w-[180px] block border-l-2 border-primary/20 pl-3 italic">{{ $class->course->title ?? 'General Knowledge' }}</span>
                        </td>
                        <td class="p-5 hidden md:table-cell">
                            <div class="text-[12px] font-[800] text-navy mb-0.5">{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y') }}</div>
                            <div class="text-[9px] text-slate-400 font-[700] uppercase tracking-[0.1em]">{{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }} &bull; {{ $class->duration }}m</div>
                        </td>
                        <td class="p-5">
                            <span @class([
                                'px-3 py-1 rounded-full text-[9px] font-[900] uppercase tracking-widest shadow-sm',
                                'bg-emerald-500 text-white' => $class->status === 'live',
                                'bg-amber-100 text-amber-600 border border-amber-200' => $class->status === 'upcoming',
                                'bg-slate-100 text-slate-500 border border-slate-200' => $class->status === 'completed',
                            ])>
                                {{ $class->status }}
                            </span>
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($class->isEnded())
                                    <div class="w-9 h-9 bg-slate-100 text-slate-300 rounded-[10px] flex items-center justify-center border border-slate-200 cursor-not-allowed" title="Broadcast Ended">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                @else
                                    <a href="{{ $class->zoom_link }}" target="_blank" class="w-9 h-9 bg-slate-50 text-slate-500 rounded-[10px] flex items-center justify-center hover:bg-navy hover:text-white transition-all border border-slate-100 shadow-sm" title="Session Node">
                                        <i class="bi bi-link-45deg text-xl"></i>
                                    </a>
                                @endif
                                <form action="{{ route('admin.live-classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Expunge this broadcast node?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 bg-pink-50 text-pink-600 rounded-[10px] flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all border border-pink-100 shadow-sm">
                                        <i class="bi bi-trash-fill text-[14px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center">
                            <div class="flex flex-col items-center gap-4 opacity-30">
                                <i class="bi bi-camera-video-off text-6xl text-navy"></i>
                                <p class="text-[10px] font-[900] text-navy uppercase tracking-[0.2em]">No active transmission nodes</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($liveClasses->hasPages())
    <div class="mt-6">
        {{ $liveClasses->links() }}
    </div>
    @endif
</div>
@endsection
