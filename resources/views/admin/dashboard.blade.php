@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Master Control Dashboard</h1>
        <p class="text-slate-500 mt-1 font-medium">Global overview of The Ace India LMS platform</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $adminStats = [
                ['label' => 'Total Students', 'value' => $stats['total_students'], 'icon' => 'bi-people', 'color' => 'bg-blue-50 text-blue-600'],
                ['label' => 'Total Revenue', 'value' => '₹' . number_format($stats['total_revenue']), 'icon' => 'bi-cash-coin', 'color' => 'bg-emerald-50 text-emerald-600'],
                ['label' => 'Pending Admissions', 'value' => $stats['pending_admissions'], 'icon' => 'bi-hourglass-split', 'color' => 'bg-amber-50 text-amber-600'],
                ['label' => 'Active Courses', 'value' => $stats['total_courses'], 'icon' => 'bi-journal-check', 'color' => 'bg-[#e3000f]/10 text-[#e3000f]'],
            ];
        @endphp

        @foreach($adminStats as $card)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1">
            <div class="w-14 h-14 {{ $card['color'] }} rounded-2xl flex items-center justify-center text-2xl shrink-0">
                <i class="{{ $card['icon'] }}"></i>
            </div>
            <div>
                <div class="text-xl font-black text-slate-900 leading-none mb-1">{{ $card['value'] }}</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Tables and Secondary Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Recent Admissions -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Recent Admission Requests</h3>
                <a href="{{ route('admin.admissions.index') }}" class="text-[10px] font-black text-[#e3000f] uppercase tracking-widest hover:underline">View All Requests</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Student</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Course</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentAdmissions as $admission)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-5">
                                <div class="text-sm font-bold text-slate-900">{{ $admission->user->name }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="text-xs font-medium text-slate-600 italic">{{ $admission->course->title }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                    {{ $admission->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                {{ $admission->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-8">
            <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#e3000f]/20 rounded-full blur-3xl"></div>
                <h3 class="text-lg font-black mb-8 flex items-center gap-2">
                    <i class="bi bi-gear-fill text-[#e3000f]"></i> Quick Setup
                </h3>
                <div class="space-y-4">
                    <a href="{{ route('admin.courses.create') }}" class="flex items-center gap-4 bg-white/5 hover:bg-white/10 p-4 rounded-2xl transition-all border border-white/10 group">
                        <div class="w-10 h-10 bg-[#e3000f] rounded-xl flex items-center justify-center text-white shrink-0 group-hover:scale-110 transition-transform">
                            <i class="bi bi-journal-plus"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest">New Course</span>
                    </a>
                    <a href="{{ route('admin.trainers.create') }}" class="flex items-center gap-4 bg-white/5 hover:bg-white/10 p-4 rounded-2xl transition-all border border-white/10 group">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shrink-0 group-hover:scale-110 transition-transform">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-widest">New Instructor</span>
                    </a>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Platform Health</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest mb-2">
                            <span class="text-slate-400">Database Storage</span>
                            <span class="text-slate-900">12% Used</span>
                        </div>
                        <div class="h-1.5 w-full bg-slate-50 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 12%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
