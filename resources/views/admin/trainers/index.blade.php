@extends('layouts.admin')

@section('title', 'Instructors')

@section('content')
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-person-badge text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Trainer <span class="text-primary">Directory</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Manage the platform's core educators</p>
                </div>
            </div>
            <a href="{{ route('admin.trainers.create') }}" class="px-6 py-3.5 bg-primary text-white font-[900] text-[12px] rounded-[12px] hover:bg-orange-600 transition-all flex items-center gap-3 uppercase tracking-widest shadow-xl shadow-orange-500/20">
                <i class="bi bi-person-plus-fill text-lg"></i>
                <span>Onboard Trainer</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[16px] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto min-w-full scrollbar-hide focus:outline-none">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Instructor Identity</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden md:table-cell">Contact Details</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden sm:table-cell">Privileges</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden lg:table-cell">Joined</th>
                        <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($trainers as $trainer)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-[12px] bg-navy/5 text-navy flex items-center justify-center font-[900] text-sm border border-slate-200 shadow-sm group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-all">
                                        {{ substr($trainer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-[14px] font-[800] text-navy leading-tight mb-1 group-hover:text-primary transition-colors uppercase leading-none">{{ $trainer->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest">UID: #{{ sprintf('%03d', $trainer->id) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 hidden md:table-cell">
                                <div class="text-[13px] font-[600] text-slate-500">{{ $trainer->email }}</div>
                            </td>
                            <td class="px-6 py-5 hidden sm:table-cell">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-[6px] text-[10px] font-[900] uppercase tracking-widest border border-slate-200 group-hover:bg-primary/5 group-hover:text-primary group-hover:border-primary/20 transition-all">
                                    Lead Instructor
                                </span>
                            </td>
                            <td class="px-6 py-5 hidden lg:table-cell text-[11px] font-[800] text-slate-400 uppercase tracking-widest">
                                {{ $trainer->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="w-[32px] h-[32px] bg-slate-50 text-slate-400 rounded-[8px] flex items-center justify-center hover:bg-navy hover:text-white transition-all shadow-sm border border-slate-200">
                                        <i class="bi bi-pencil-square text-[16px]"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-400 italic font-bold">No trainers found in system.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </table>
        </div>
        @if($trainers->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $trainers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
