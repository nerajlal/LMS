@extends('layouts.admin')

@section('title', 'Trainer Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $statCards = [
                ['label' => 'Active Courses', 'value' => $stats['courses'], 'icon' => 'bi-journal-bookmark', 'color' => 'bg-[#F37021]'],
                ['label' => 'Total Students', 'value' => $stats['students'], 'icon' => 'bi-people', 'color' => 'bg-blue-600'],
                ['label' => 'Live Classes', 'value' => $stats['live_classes'], 'icon' => 'bi-camera-video', 'color' => 'bg-emerald-600'],
            ];
        @endphp

        @foreach($statCards as $card)
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-5 transition-all hover:shadow-md">
            <div class="w-14 h-14 rounded-full {{ $card['color'] }} flex items-center justify-center text-white text-2xl shadow-lg shadow-inner">
                <i class="{{ $card['icon'] }}"></i>
            </div>
            <div>
                <div class="text-2xl font-black text-slate-900 leading-none mb-1">{{ $card['value'] }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-900 tracking-tight">Recent Courses</h2>
                    <a href="{{ route('trainer.courses.index') }}" class="text-xs font-bold text-[#F37021] uppercase tracking-widest hover:underline">View All</a>
                </div>
                <div class="p-10 text-center">
                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="bi bi-journal-x"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Head over to Course Management to get started.</p>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-black text-slate-900 tracking-tight">Quick Actions</h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('trainer.live-classes.index') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-[#F37021] text-white font-bold rounded-xl hover:bg-[#E6631E] transition-all shadow-lg shadow-orange-500/20 text-sm">
                        <i class="bi bi-plus-lg"></i> Schedule Live Class
                    </a>
                    <a href="{{ route('trainer.courses.index') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20 text-sm">
                        <i class="bi bi-upload"></i> Upload Material
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
