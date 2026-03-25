@extends('layouts.admin')

@section('title', 'Trainer Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $statCards = [
                ['label' => 'Active Courses', 'value' => $stats['courses'], 'icon' => 'bi-journal-bookmark', 'color' => '#1B365D'],
                ['label' => 'Total Students', 'value' => $stats['students'], 'icon' => 'bi-people', 'color' => '#F37021'],
                ['label' => 'Avg Rating', 'value' => '4.8', 'icon' => 'bi-star-fill', 'color' => '#F37021'],
                ['label' => 'Live Classes', 'value' => $stats['live_classes'], 'icon' => 'bi-camera-video', 'color' => '#1B365D'],
            ];
        @endphp

        @foreach($statCards as $card)
        <div class="bg-white p-6 rounded-[12px] border border-border flex items-center gap-[20px] transition-all hover:shadow-sm">
            <div class="w-[48px] h-[48px] rounded-full flex items-center justify-center text-white shrink-0" style="background: {{ $card['color'] }}">
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
        <!-- Recent Courses -->
        <div class="lg:col-span-8 flex flex-col">
            <div class="bg-white rounded-[12px] border border-border overflow-hidden h-full">
                <div class="p-[24px] border-b border-border flex justify-between items-center">
                    <h2 class="text-[18px] font-[800] text-navy">My Recent Courses</h2>
                    <a href="{{ route('trainer.courses.index') }}" class="text-primary text-[13px] font-[700] hover:underline">See all</a>
                </div>
                <div class="py-[48px] text-center">
                    <div class="w-[64px] h-[64px] bg-border text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-[24px]">
                        <i class="bi bi-journal-x"></i>
                    </div>
                    <p class="text-muted text-[14px]">No courses assigned yet.</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[12px] border border-border overflow-hidden">
                <div class="p-[24px] border-b border-border">
                    <h2 class="text-[18px] font-[800] text-navy">Quick Actions</h2>
                </div>
                <div class="p-[24px] flex flex-col gap-[12px]">
                    <a href="{{ route('trainer.live-classes.index') }}" class="w-full py-[12px] bg-primary text-white font-[700] rounded-[8px] text-center hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/10">Schedule Live Class</a>
                    <a href="{{ route('trainer.courses.index') }}" class="w-full py-[12px] border border-navy text-navy font-[700] rounded-[8px] text-center hover:bg-navy hover:text-white transition-all">Manage Course Content</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
