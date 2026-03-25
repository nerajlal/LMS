@extends('layouts.admin')

@section('title', 'Live Classes')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Live Class Schedule</h1>
            <p class="text-sm text-slate-500 font-medium italic">Manage your upcoming interactive sessions with students</p>
        </div>
        <a href="{{ route('trainer.live-classes.create') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-[#F37021] text-white font-black rounded-2xl hover:bg-[#E6631E] transition-all shadow-lg shadow-orange-500/20 text-xs uppercase tracking-widest">
            <i class="bi bi-calendar-plus text-base"></i> Schedule New Class
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Live Class Info</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Course</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Schedule</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Link</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($classes as $class)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-slate-900 group-hover:text-[#F37021] transition-colors">{{ $class->title }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Instructor: {{ $class->instructor_name }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold uppercase tracking-widest italic">
                                {{ $class->course->title ?? 'General' }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-xs font-bold text-slate-700">{{ \Carbon\Carbon::parse($class->start_time)->format('M d, Y') }}</div>
                            <div class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} ({{ $class->duration }})</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest {{ $class->status === 'live' ? 'text-emerald-600' : 'text-amber-500' }}">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $class->status === 'live' ? 'bg-emerald-400' : 'bg-amber-400' }} opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 {{ $class->status === 'live' ? 'bg-emerald-600' : 'bg-amber-500' }}"></span>
                                </span>
                                {{ $class->status }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <a href="{{ $class->zoom_link }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all">
                                Join Session <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                <i class="bi bi-camera-video-off"></i>
                            </div>
                            <p class="text-slate-500 font-bold">No live classes scheduled.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
