@extends('layouts.admin')

@section('title', 'Manage Live Classes - Admin')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-[800] text-navy tracking-tight">Live Class Scheduling</h1>
            <p class="text-muted mt-1 font-[500]">Manage and monitor all live interactive sessions across the platform</p>
        </div>
        <a href="{{ route('admin.live-classes.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white font-[800] rounded-[12px] hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20 text-[13px] uppercase tracking-widest">
            <i class="bi bi-plus-lg text-lg"></i> Schedule Live Class
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-[12px] border border-border shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Session Details</th>
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Course</th>
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Schedule</th>
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border">Status</th>
                        <th class="px-8 py-6 text-[11px] font-[800] text-muted uppercase tracking-wider border-b border-border text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($liveClasses as $class)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div @class([
                                    'w-10 h-10 rounded-[10px] flex items-center justify-center text-lg shrink-0',
                                    'bg-emerald-50 text-emerald-600' => $class->status === 'live',
                                    'bg-amber-50 text-amber-600' => $class->status === 'upcoming',
                                    'bg-slate-50 text-slate-400' => $class->status === 'completed',
                                ])>
                                    <i class="bi bi-camera-video-fill"></i>
                                </div>
                                <div>
                                    <div class="text-[14px] font-[800] text-navy leading-tight mb-1 group-hover:text-primary transition-colors">{{ $class->title }}</div>
                                    <div class="text-[11px] text-muted font-[600] italic">{{ $class->instructor_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[13px] font-[700] text-navy">{{ $class->course->title ?? 'General' }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-[13px] font-[700] text-navy mb-1">{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y') }}</div>
                            <div class="text-[11px] text-muted font-[600] uppercase tracking-wider">{{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }} ({{ $class->duration }}m)</div>
                        </td>
                        <td class="px-8 py-6">
                            <span @class([
                                'px-3 py-1 rounded-[8px] text-[10px] font-[800] uppercase tracking-widest',
                                'bg-emerald-50 text-emerald-600' => $class->status === 'live',
                                'bg-amber-50 text-amber-600' => $class->status === 'upcoming',
                                'bg-slate-50 text-slate-500' => $class->status === 'completed',
                            ])>
                                {{ $class->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ $class->zoom_link }}" target="_blank" class="p-2 text-muted hover:text-primary transition-colors" title="Zoom Link">
                                    <i class="bi bi-link-45deg text-xl"></i>
                                </a>
                                <form action="{{ route('admin.live-classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Delete this session?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-muted hover:text-red-500 transition-colors">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-muted font-[600] italic">No live classes scheduled yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($liveClasses->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-border">
            {{ $liveClasses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
