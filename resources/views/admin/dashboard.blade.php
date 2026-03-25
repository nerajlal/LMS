@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $adminStats = [
                ['label' => 'Total Students', 'value' => $stats['total_students'], 'icon' => 'bi-people', 'color' => '#1B365D'],
                ['label' => 'Total Revenue', 'value' => '₹' . number_format($stats['total_revenue']), 'icon' => 'bi-cash-coin', 'color' => '#F37021'],
                ['label' => 'Pending Admissions', 'value' => $stats['pending_admissions'], 'icon' => 'bi-hourglass-split', 'color' => '#F37021'],
                ['label' => 'Active Courses', 'value' => $stats['total_courses'], 'icon' => 'bi-journal-check', 'color' => '#1B365D'],
            ];
        @endphp

        @foreach($adminStats as $card)
        <div class="bg-white p-6 rounded-[12px] border border-border flex items-center gap-[20px] transition-all hover:shadow-sm">
            <div class="w-[48px] h-[48px] rounded-[12px] flex items-center justify-center text-white shrink-0" style="background: {{ $card['color'] }}">
                <i class="bi {{ $card['icon'] }} text-[20px]"></i>
            </div>
            <div>
                <div class="text-[24px] font-[800] text-navy leading-none mb-1">{{ $card['value'] }}</div>
                <div class="text-[13px] font-[500] text-muted">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Recent Admissions -->
        <div class="lg:col-span-8 flex flex-col">
            <div class="bg-white rounded-[12px] border border-border overflow-hidden h-full">
                <div class="p-[24px] border-b border-border flex justify-between items-center">
                    <h2 class="text-[18px] font-[800] text-navy">Recent Admission Requests</h2>
                    <a href="{{ route('admin.admissions.index') }}" class="text-primary text-[13px] font-[700] hover:underline">See all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-border/30">
                                <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Student</th>
                                <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Course</th>
                                <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Status</th>
                                <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($recentAdmissions as $admission)
                            <tr class="hover:bg-border/10 transition-colors">
                                <td class="px-[24px] py-[16px]">
                                    <div class="text-[14px] font-[700] text-navy">{{ $admission->user->name }}</div>
                                </td>
                                <td class="px-[24px] py-[16px]">
                                    <div class="text-[13px] text-muted truncate max-w-[200px]">{{ $admission->course->title }}</div>
                                </td>
                                <td class="px-[24px] py-[16px]">
                                    <span class="px-[12px] py-[4px] bg-accent text-primary rounded-[6px] text-[11px] font-[700] uppercase">
                                        {{ $admission->status }}
                                    </span>
                                </td>
                                <td class="px-[24px] py-[16px] text-[12px] text-muted text-right font-[500]">
                                    {{ $admission->created_at->format('M d, Y') }}
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
            <div class="bg-white rounded-[12px] border border-border overflow-hidden">
                <div class="p-[24px] border-b border-border">
                    <h2 class="text-[18px] font-[800] text-navy">Quick Setup</h2>
                </div>
                <div class="p-[24px] space-y-3">
                    <a href="{{ route('admin.courses.create') }}" class="flex items-center gap-[12px] p-[12px] rounded-[8px] bg-border/50 hover:bg-border transition-all group">
                        <div class="w-[40px] h-[40px] bg-primary rounded-[8px] flex items-center justify-center text-white shrink-0">
                            <i class="bi bi-journal-plus text-[18px]"></i>
                        </div>
                        <span class="text-[13px] font-[700] text-navy group-hover:text-primary transition-colors">New Course Creation</span>
                    </a>
                    <a href="{{ route('admin.trainers.create') }}" class="flex items-center gap-[12px] p-[12px] rounded-[8px] bg-border/50 hover:bg-border transition-all group">
                        <div class="w-[40px] h-[40px] bg-navy rounded-[8px] flex items-center justify-center text-white shrink-0">
                            <i class="bi bi-person-plus text-[18px]"></i>
                        </div>
                        <span class="text-[13px] font-[700] text-navy group-hover:text-primary transition-colors">Add New Instructor</span>
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
