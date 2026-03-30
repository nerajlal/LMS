@extends('layouts.admin')

@section('title', 'Registered Students')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-people text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Learner <span class="text-primary">Directory</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Manage and monitor institutional enrollment</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-5 py-3 rounded-[16px] backdrop-blur-sm">
                <span class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest">Active Learners</span>
                <span class="text-xl font-[900] text-primary">{{ sprintf('%02d', $students->total()) }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full scrollbar-hide focus:outline-none">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Student Profile</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden md:table-cell text-center">Involvement</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Contact Details</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($students as $student)
                        <tr class="hover:bg-slate-50/30 transition-colors group {{ !$student->is_active ? 'opacity-75 grayscale-[0.5]' : '' }}">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-[12px] {{ $student->is_active ? 'bg-navy/5 text-navy' : 'bg-slate-200 text-slate-400' }} flex items-center justify-center font-[900] text-sm border border-slate-200 shadow-sm group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-[14px] font-[800] text-navy leading-tight mb-1 group-hover:text-primary transition-colors uppercase leading-none">{{ $student->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest">{{ $student->is_active ? 'Verified Learner' : 'Account Suspended' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 hidden md:table-cell">
                                <div class="flex items-center justify-center gap-6">
                                    <div class="text-center">
                                        <div class="text-[14px] font-[900] text-navy leading-none mb-1">{{ $student->admissions_count }}</div>
                                        <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest">Applied</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-[14px] font-[900] text-emerald-600 leading-none mb-1">{{ $student->enrollments_count }}</div>
                                        <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest">Active</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-[13px] font-[600] text-navy mb-1">{{ $student->email }}</div>
                                <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest italic">Since {{ $student->created_at->format('M Y') }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-2.5 py-1 {{ $student->is_active ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }} rounded-lg text-[9px] font-[900] uppercase tracking-widest border shadow-sm">
                                    {{ $student->is_active ? 'Authorized' : 'Frozen' }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2 text-right">
                                    <form action="{{ route('admin.students.toggle-status', $student->id) }}" method="POST" onsubmit="return confirm('Change status for this student?')">
                                        @csrf
                                        <button type="submit" class="w-[32px] h-[32px] {{ $student->is_active ? 'bg-amber-50 text-amber-500 hover:bg-amber-500' : 'bg-emerald-50 text-emerald-500 hover:bg-emerald-500' }} rounded-[8px] flex items-center justify-center hover:text-white transition-all shadow-sm border border-slate-200" title="{{ $student->is_active ? 'Freeze Account' : 'Activate Account' }}">
                                            <i class="bi {{ $student->is_active ? 'bi-snow' : 'bi-fire' }} text-[16px]"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.admissions.index', ['user_id' => $student->id]) }}" class="w-[32px] h-[32px] bg-slate-50 text-slate-400 rounded-[8px] flex items-center justify-center hover:bg-navy hover:text-white transition-all shadow-sm border border-slate-200" title="View History">
                                        <i class="bi bi-clock-history text-[16px]"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-[64px] text-center text-muted italic font-[600]">No students registered.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
        <div class="px-[24px] py-[16px] bg-border/20 border-t border-border">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
