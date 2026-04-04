@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-10 focus:outline-none">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-8 md:p-10 text-white shadow-2xl border border-white/5">
        <div class="absolute top-[-40px] right-[-40px] w-[300px] h-[300px] bg-primary/20 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-[-60px] left-[-60px] w-[200px] h-[200px] bg-sky-500/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-[18px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-xl shadow-2xl group overflow-hidden shrink-0">
                    <i class="bi bi-shield-lock text-primary text-3xl group-hover:scale-110 transition-transform duration-500"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-[900] tracking-tight leading-tight uppercase">Admin <span class="text-primary">Console</span></h1>
                    <p class="text-slate-400 text-[11px] md:text-[13px] font-[600] uppercase tracking-[0.2em] mt-1.5 flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_#4ade80]"></span>
                        System Controller &bull; Institutional Access
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 bg-white/5 border border-white/10 p-5 rounded-[24px] backdrop-blur-md self-start md:self-auto min-w-[200px]">
                <div class="w-11 h-11 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                    <i class="bi bi-cpu text-xl"></i>
                </div>
                <div>
                    <div class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest leading-none mb-1.5">System Load</div>
                    <div class="text-xl font-[900] text-white leading-none">Optimal <span class="text-[10px] text-emerald-400 ml-1 uppercase">Stable</span></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Premium Intelligence Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $adminStats = [
                ['label' => 'Total Students', 'value' => $stats['total_students'], 'icon' => 'bi-people-fill', 'gradient' => 'from-navy to-[#254d85]', 'iconColor' => 'text-primary'],
                ['label' => 'Total Revenue', 'value' => '₹' . number_format($stats['total_revenue']), 'icon' => 'bi-cash-stack', 'gradient' => 'from-white to-slate-50', 'iconColor' => 'text-navy'],
                ['label' => 'Active Courses', 'value' => $stats['total_courses'], 'icon' => 'bi-journal-check', 'gradient' => 'from-white to-slate-50', 'iconColor' => 'text-emerald-500'],
                ['label' => 'Total Admissions', 'value' => $stats['total_admissions'], 'icon' => 'bi-clipboard-check', 'gradient' => 'from-white to-slate-50', 'iconColor' => 'text-blue-500'],
            ];
        @endphp

        @foreach($adminStats as $index => $card)
        <div class="relative group bg-gradient-to-br {{ $card['gradient'] }} p-5 rounded-[20px] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 overflow-hidden {{ $index === 0 ? 'text-white border-navy shadow-navy/10' : 'bg-white' }}">
            @if($index === 0)
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="bi {{ $card['icon'] }} text-[64px]"></i>
                </div>
            @endif
            
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-[14px] {{ $index === 0 ? 'bg-white/10' : 'bg-slate-50' }} flex items-center justify-center {{ $card['iconColor'] }} shadow-inner shrink-0 group-hover:scale-110 transition-transform">
                    <i class="bi {{ $card['icon'] }} text-xl"></i>
                </div>
                <div class="min-w-0 pr-2">
                    <div class="text-2xl font-[900] {{ $index === 0 ? 'text-white' : 'text-navy' }} leading-none mb-1.5 tracking-tight uppercase">{{ is_numeric($card['value']) ? sprintf('%02d', $card['value']) : $card['value'] }}</div>
                    <div class="text-[10px] font-[800] {{ $index === 0 ? 'text-slate-300' : 'text-slate-400' }} uppercase tracking-widest leading-tight line-clamp-1 truncate">{{ $card['label'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Recent Admissions -->
        <div class="lg:col-span-8 flex flex-col">
            <div class="bg-white rounded-[20px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden h-full">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-50 text-navy rounded-[8px] flex items-center justify-center">
                            <i class="bi bi-clock-history text-sm"></i>
                        </div>
                        <h2 class="text-[13px] font-[900] text-navy uppercase tracking-widest mt-0.5">Recent Admissions</h2>
                    </div>
                    <a href="{{ route('admin.admissions.index') }}" class="text-primary text-[11px] font-[900] uppercase tracking-widest hover:underline decoration-2 underline-offset-4">See All</a>
                </div>
                <div class="overflow-x-auto min-w-full">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Student Profile</th>
                                <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider hidden md:table-cell">Target Course</th>
                                <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-[11px] font-[800] text-navy uppercase tracking-wider text-right">Log Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentAdmissions as $admission)
                            <tr class="hover:bg-slate-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="text-[14px] font-[800] text-navy group-hover:text-primary transition-colors leading-tight">{{ $admission->user->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1.5 md:hidden">
                                        {{ $admission->course?->title ?? 'Live Batch Program' }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 hidden md:table-cell">
                                    <div class="text-[13px] font-[600] text-slate-500 truncate max-w-[200px]">{{ $admission->course?->title ?? 'Live Batch Program' }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex px-3 py-1 bg-orange-50 text-primary rounded-[6px] text-[10px] font-[900] uppercase tracking-widest border border-orange-100/50">
                                        {{ $admission->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="text-[12px] font-[800] text-navy">{{ $admission->created_at->format('M d, Y') }}</div>
                                    <div class="text-[10px] text-slate-400 font-[600] uppercase tracking-wider mt-0.5">{{ $admission->created_at->format('g:i A') }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-[20px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-8 h-8 bg-primary/10 rounded-[8px] flex items-center justify-center text-primary">
                        <i class="bi bi-lightning-charge-fill text-sm"></i>
                    </div>
                    <h2 class="text-[13px] font-[900] text-navy uppercase tracking-widest mt-0.5">Quick Setup</h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('admin.courses.create') }}" class="flex items-center gap-4 p-4 rounded-[14px] bg-slate-50 hover:bg-navy hover:text-white transition-all group">
                        <div class="w-10 h-10 bg-white rounded-[10px] flex items-center justify-center text-navy shrink-0 shadow-sm border border-slate-200 group-hover:border-navy transition-all">
                            <i class="bi bi-journal-plus text-lg group-hover:text-primary transition-colors"></i>
                        </div>
                        <span class="text-[12px] font-[800] uppercase tracking-widest">New Course</span>
                    </a>
                    <a href="{{ route('admin.trainers.create') }}" class="flex items-center gap-4 p-4 rounded-[14px] bg-slate-50 hover:bg-navy hover:text-white transition-all group">
                        <div class="w-10 h-10 bg-white rounded-[10px] flex items-center justify-center text-navy shrink-0 shadow-sm border border-slate-200 group-hover:border-navy transition-all">
                            <i class="bi bi-person-plus text-lg group-hover:text-primary transition-colors"></i>
                        </div>
                        <span class="text-[12px] font-[800] uppercase tracking-widest">Add Instructor</span>
                    </a>
                </div>
            </div>

            <!-- Health Widget -->
            <div class="bg-white p-[24px] rounded-[12px] border border-border">
                <h3 class="text-[13px] font-[700] text-muted uppercase tracking-widest mb-[20px]">System Health</h3>
                <div class="space-y-[16px]">
                    <div>
                        <div class="flex justify-between text-[11px] font-[700] mb-[8px]">
                            <span class="text-muted uppercase">Cloud Storage</span>
                            <span class="text-navy">12%</span>
                        </div>
                        <div class="h-[6px] w-full bg-border rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 12%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
