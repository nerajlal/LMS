@extends('layouts.admin')

@section('title', 'Instructors')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Instructor Directory</h1>
            <p class="text-slate-500 mt-1 font-medium italic">Manage the educators and trainers contributing to the platform</p>
        </div>
        <a href="{{ route('admin.trainers.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-black transition-all shadow-xl shadow-slate-900/20 text-xs uppercase tracking-widest">
            <i class="bi bi-person-plus-fill text-base"></i> Onboard New Trainer
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Identity</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Contact Info</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Role Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Onboarded</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($trainers as $trainer)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs border border-white shadow-sm">
                                    {{ substr($trainer->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900 leading-tight mb-1">{{ $trainer->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">ID: {{ $trainer->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-[11px] font-bold text-slate-600 mb-1">{{ $trainer->email }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                Lead Instructor
                            </span>
                        </td>
                        <td class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ $trainer->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button class="p-2 text-slate-300 hover:text-blue-600 transition-colors">
                                <i class="bi bi-pencil-square text-xl"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-400 italic font-bold">No trainers found in system.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($trainers->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
            {{ $trainers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
