@extends('layouts.admin')

@section('title', 'Trainer Dashboard')

@section('content')
<div class="space-y-8">
<div class="space-y-8">
    <!-- Cinematic Trainer Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-[14px] md:rounded-[16px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-person-workspace text-primary text-2xl md:text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight">Instructor <span class="text-primary">Workspace</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Welcome back, {{ auth()->user()->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('trainer.courses.create') }}" class="px-5 py-3 bg-primary text-white text-[11px] font-[900] uppercase tracking-widest rounded-[12px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 flex items-center gap-2">
                    <i class="bi bi-plus-lg text-lg"></i>
                    <span>New Course</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Interactive Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        @php
            $statCards = [
                ['label' => 'Active Courses', 'value' => $stats['courses'], 'icon' => 'bi-journal-bookmark', 'color' => 'text-navy', 'bg' => 'bg-slate-100'],
                ['label' => 'Total Students', 'value' => $stats['students'], 'icon' => 'bi-people', 'color' => 'text-primary', 'bg' => 'bg-orange-50'],
                ['label' => 'Avg Rating', 'value' => '4.8', 'icon' => 'bi-star-fill', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50'],
                ['label' => 'Live Classes', 'value' => $stats['live_classes'], 'icon' => 'bi-camera-video', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
            ];
        @endphp

        @foreach($statCards as $card)
        <div class="bg-white p-4 md:p-6 rounded-[16px] border border-border flex items-center gap-4 transition-all hover:shadow-md group">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-[12px] {{ $card['bg'] }} {{ $card['color'] }} flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <i class="bi {{ $card['icon'] }} text-lg md:text-xl"></i>
            </div>
            <div>
                <div class="text-lg md:text-2xl font-[900] text-navy leading-none mb-1">{{ $card['value'] }}</div>
                <div class="text-[9px] md:text-[11px] font-[800] text-muted uppercase tracking-widest">{{ $card['label'] }}</div>
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
                <div class="p-2 md:p-4">
                    @forelse($recentCourses as $course)
                    <div class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-[12px] group transition-all">
                        <div class="w-16 h-12 md:w-20 md:h-14 rounded-[10px] overflow-hidden shrink-0 bg-border shadow-sm">
                            <img src="{{ $course->thumbnail ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=200' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-navy font-[800] text-[14px] md:text-[15px] mb-0.5 truncate group-hover:text-primary transition-colors leading-tight">{{ $course->title }}</div>
                            <div class="flex items-center gap-3 text-[10px] md:text-[11px] text-slate-400 font-[700] uppercase tracking-wider">
                                <span class="flex items-center gap-1.5"><i class="bi bi-play-circle text-primary"></i> {{ $course->lessons_count }} Lessons</span>
                                <span class="flex items-center gap-1.5"><i class="bi bi-people-fill text-primary"></i> {{ $course->admissions->count() }} Students</span>
                            </div>
                        </div>
                        <a href="{{ route('trainer.courses.show', $course->id) }}" class="w-8 h-8 md:w-auto md:px-4 md:py-2 bg-slate-100 text-navy rounded-[8px] flex items-center justify-center text-[12px] font-[800] hover:bg-navy hover:text-white transition-all uppercase tracking-widest whitespace-nowrap">
                            <span class="hidden md:inline">Manage</span>
                            <i class="bi bi-chevron-right md:ml-2"></i>
                        </a>
                    </div>
                    @empty
                    <div class="py-[48px] text-center">
                        <div class="w-[64px] h-[64px] bg-border text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-[24px]">
                            <i class="bi bi-journal-x"></i>
                        </div>
                        <p class="text-muted text-[14px]">No courses assigned yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[12px] border border-border overflow-hidden">
                <div class="p-[24px] border-b border-border">
                    <h2 class="text-[18px] font-[800] text-navy">Quick Actions</h2>
                </div>
                <div class="p-6 flex flex-col gap-3">
                    <a href="{{ route('trainer.live-classes.index') }}" class="w-full py-3 bg-primary text-white font-[800] text-[12px] rounded-[10px] text-center hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 uppercase tracking-widest">Schedule Sessions</a>
                    <a href="{{ route('trainer.courses.index') }}" class="w-full py-3 border border-border text-navy font-[800] text-[12px] rounded-[10px] text-center hover:bg-navy hover:text-white transition-all uppercase tracking-widest">Master Curriculum</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
