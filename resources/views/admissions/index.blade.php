@extends('layouts.app')

@section('title', 'My Enrollments - The Ace India')

@section('content')
<div class="space-y-12">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">My Course Applications</h1>
        <p class="text-slate-500 mt-1 font-medium">Track the status of your admissions and enrollments</p>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Applied Course</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Batch</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Application Date</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($admissions as $admission)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="text-sm font-bold text-slate-900 group-hover:text-[#F37021] transition-colors leading-tight">
                                {{ $admission->course->title ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-medium text-slate-500 italic">
                                {{ $admission->batch->name ?? 'Universal' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ $admission->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $statusStyles = [
                                    'approved' => 'bg-emerald-50 text-emerald-600',
                                    'pending'  => 'bg-amber-50 text-amber-600',
                                    'rejected' => 'bg-red-50 text-red-600',
                                ];
                                $style = $statusStyles[$admission->status] ?? 'bg-slate-50 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 {{ $style }} rounded-lg text-[10px] font-black uppercase tracking-widest">
                                {{ $admission->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            @if($admission->status === 'approved')
                                <a href="{{ route('courses.show', $admission->course_id) }}" class="inline-flex items-center gap-2 text-[#F37021] font-black text-[10px] uppercase tracking-widest hover:underline">
                                    Start Learning <i class="bi bi-play-circle-fill text-base"></i>
                                </a>
                            @else
                                <span class="text-slate-300 font-bold text-[10px] uppercase tracking-widest italic">Awaiting Approval</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <p class="text-slate-400 font-bold italic">No applications found.</p>
                            <a href="{{ route('courses.index') }}" class="mt-4 inline-block text-[#F37021] font-black uppercase tracking-widest text-[10px] hover:underline">
                                Browse Courses <i class="bi bi-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
