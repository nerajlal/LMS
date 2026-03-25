@extends('layouts.admin')

@section('title', 'Live Classes')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-[24px] font-[800] text-navy tracking-tight">Live Class Schedule</h1>
            <p class="text-muted mt-1 font-[500] text-[14px]">Manage your upcoming interactive sessions with students</p>
        </div>
        <a href="{{ route('trainer.live-classes.create') }}" class="inline-flex items-center gap-[10px] px-[24px] py-[12px] bg-primary text-white font-[700] rounded-[8px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/10 text-[14px]">
            <i class="bi bi-plus-lg"></i> Schedule New Class
        </a>
    </div>

    <div class="bg-white rounded-[12px] border border-border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-border/30">
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Live Class Info</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Course</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Schedule</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Status</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider text-right">Link</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($classes as $class)
                    <tr class="hover:bg-border/10 transition-colors group">
                        <td class="px-[24px] py-[16px]">
                            <div class="text-[14px] font-[700] text-navy group-hover:text-primary transition-colors truncate max-w-[200px]">{{ $class->title }}</div>
                            <div class="text-[11px] text-muted font-[600] uppercase tracking-wider mt-1">Instructor: {{ $class->instructor_name }}</div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <span class="inline-flex px-[10px] py-[4px] bg-border/50 text-navy rounded-[6px] text-[11px] font-[700] uppercase">
                                {{ $class->course->title ?? 'General' }}
                            </span>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="text-[13px] font-[700] text-navy">{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y') }}</div>
                            <div class="text-[11px] text-muted font-[600] uppercase tracking-wider mt-1">{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} ({{ $class->duration }})</div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="flex items-center gap-[8px] text-[11px] font-[800] uppercase tracking-widest {{ $class->status === 'live' ? 'text-emerald-600' : 'text-amber-500' }}">
                                <span class="relative flex h-[8px] w-[8px]">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $class->status === 'live' ? 'bg-emerald-400' : 'bg-amber-400' }} opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-[8px] w-[8px] {{ $class->status === 'live' ? 'bg-emerald-600' : 'bg-amber-500' }}"></span>
                                </span>
                                {{ $class->status }}
                            </div>
                        </td>
                        <td class="px-[24px] py-[16px] text-right">
                            <a href="{{ $class->zoom_link }}" target="_blank" class="inline-flex items-center gap-[8px] px-[16px] py-[8px] bg-accent text-primary rounded-[8px] text-[11px] font-[800] uppercase tracking-widest hover:bg-primary hover:text-white transition-all shadow-sm">
                                Join Session <i class="bi bi-box-arrow-up-right"></i>
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
