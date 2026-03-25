@extends('layouts.admin')

@section('title', 'Registered Students')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Student Directory</h1>
            <p class="text-slate-500 mt-1 font-medium italic">Monitor and manage all learners registered on the platform</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="px-6 py-4 bg-white border border-slate-100 rounded-2xl text-[10px] font-black text-slate-400 uppercase tracking-widest">
                Total Students: <span class="text-slate-900">{{ $students->total() }}</span>
            </span>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Identity</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Contact Info</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Involvement</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Registration</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($students as $student)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-[#F37021]/10 text-[#F37021] flex items-center justify-center font-black text-xs border border-white shadow-sm">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900 leading-tight mb-1">{{ $student->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">UID: {{ $student->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-[11px] font-bold text-slate-600 mb-1">{{ $student->email }}</div>
                            <div class="text-[10px] text-slate-400 font-medium">No phone provided</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-6">
                                <div class="text-center">
                                    <div class="text-xs font-black text-slate-900 leading-none mb-1">{{ $student->admissions_count }}</div>
                                    <div class="text-[8px] text-slate-400 font-black uppercase tracking-widest">Applied</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-xs font-black text-emerald-600 leading-none mb-1">{{ $student->enrollments_count }}</div>
                                    <div class="text-[8px] text-slate-400 font-black uppercase tracking-widest">Active</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ $student->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button class="p-2 text-slate-300 hover:text-[#F37021] transition-colors">
                                <i class="bi bi-three-dots-vertical text-xl"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-400 italic font-bold">No students registered.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
