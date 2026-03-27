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
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Live Class <span class="text-primary">Schedule</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Manage your interactive sessions</p>
                </div>
            </div>
            <a href="{{ route('trainer.live-classes.create') }}" class="px-6 py-3.5 bg-primary text-white font-[900] text-[12px] rounded-[12px] hover:bg-orange-600 transition-all flex items-center gap-3 uppercase tracking-widest shadow-xl shadow-orange-500/20">
                <i class="bi bi-plus-lg text-lg"></i>
                <span>Schedule Session</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[12px] border border-border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-border">
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Session Info</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Target Course</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Schedule</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right">Access</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($classes as $class)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="text-[14px] font-[800] text-navy group-hover:text-primary transition-colors leading-tight truncate max-w-[200px]">{{ $class->title }}</div>
                            <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1.5 flex items-center gap-2">
                                <i class="bi bi-person-badge text-primary"></i> {{ $class->instructor_name }}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex px-2.5 py-1 bg-slate-100 text-navy rounded-[6px] text-[10px] font-[900] uppercase tracking-widest border border-slate-200">
                                {{ $class->course->title ?? 'General' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-[13px] font-[800] text-navy">{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y') }}</div>
                            <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} ({{ $class->duration }})</div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2 text-[10px] font-[900] uppercase tracking-widest {{ $class->status === 'live' ? 'text-emerald-600' : 'text-amber-500' }}">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $class->status === 'live' ? 'bg-emerald-400' : 'bg-amber-400' }} opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 {{ $class->status === 'live' ? 'bg-emerald-600' : 'bg-amber-500' }}"></span>
                                </span>
                                {{ $class->status }}
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <a href="{{ $class->zoom_link }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-navy rounded-[10px] text-[11px] font-[800] uppercase tracking-widest hover:bg-navy hover:text-white transition-all shadow-sm border border-slate-200">
                                Join <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-[64px] text-center">
                            <i class="bi bi-camera-video-off text-[32px] text-border mb-4 block"></i>
                            <p class="text-muted font-[600] italic">No live classes scheduled.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
