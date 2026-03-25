@extends('layouts.app')

@section('title', 'Student Dashboard - The Ace India')

@section('content')
<div class="space-y-12">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Howdy, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm">Welcome back to your learning journey. You're doing great!</p>
        </div>
        <div class="flex items-center gap-3 p-1.5 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-lg">
                <i class="bi bi-fire"></i>
            </div>
            <div class="pr-4">
                <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest leading-none mb-1">Learning Streak</div>
                <div class="text-base font-black text-slate-900">12 Days</div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $statCards = [
                ['label' => 'Enrolled', 'value' => $stats['enrolled'], 'icon' => 'bi-journal-bookmark', 'color' => 'bg-blue-50 text-blue-600'],
                ['label' => 'Live Classes', 'value' => $stats['liveClasses'], 'icon' => 'bi-camera-video', 'color' => 'bg-red-50 text-[#F37021]'],
                ['label' => 'Completed', 'value' => $stats['completed'], 'icon' => 'bi-check2-circle', 'color' => 'bg-emerald-50 text-emerald-600'],
                ['label' => 'Fees Due', 'value' => '₹'.$stats['feesDue'], 'icon' => 'bi-currency-dollar', 'color' => 'bg-amber-50 text-amber-600'],
            ];
        @endphp

        @foreach($statCards as $card)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4 transition-transform hover:-translate-y-1">
            <div class="w-12 h-12 {{ $card['color'] }} rounded-2xl flex items-center justify-center text-xl shrink-0 shadow-inner">
                <i class="{{ $card['icon'] }}"></i>
            </div>
            <div>
                <div class="text-xl font-black text-slate-900 leading-none mb-1">{{ $card['value'] }}</div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Courses Section -->
        <div class="lg:col-span-2 space-y-8">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Continue Learning</h2>
                <a href="{{ route('courses.index') }}" class="text-sm font-bold text-[#F37021] hover:underline">View All</a>
            </div>

            <div class="space-y-4">
                @forelse($enrolledCourses as $course)
                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md flex items-center gap-6 group">
                    <div class="w-24 h-24 bg-slate-100 rounded-2xl overflow-hidden shrink-0 relative">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=200" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="bi bi-play-circle-fill text-white text-3xl"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-slate-900 mb-2 truncate group-hover:text-[#F37021] transition-colors leading-tight">{{ $course['title'] }}</h3>
                        <div class="flex items-center gap-6 mb-4">
                            <div class="flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                <i class="bi bi-person text-base"></i> {{ $course['instructor'] }}
                            </div>
                            <div class="flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                <i class="bi bi-play-btn text-base"></i> {{ $course['lessons_count'] }} Lessons
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-[#F37021] transition-all duration-500 rounded-full" style="width: {{ $course['progress'] }}%"></div>
                            </div>
                            <span class="text-xs font-black text-slate-900">{{ $course['progress'] }}%</span>
                        </div>
                    </div>
                    <div class="hidden sm:block">
                        <a href="{{ route('courses.show', $course['id']) }}" class="p-3 rounded-2xl bg-slate-50 text-slate-400 hover:bg-[#F37021] hover:text-white transition-all">
                            <i class="bi bi-chevron-right text-xl"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="bg-white py-20 rounded-[3rem] border-2 border-dashed border-slate-200 text-center">
                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="bi bi-journal-x"></i>
                    </div>
                    <p class="text-slate-500 font-bold">You aren't enrolled in any courses yet.</p>
                    <a href="{{ route('courses.index') }}" class="mt-4 inline-flex items-center gap-2 text-[#F37021] font-black uppercase tracking-widest text-xs hover:underline">
                        Find a Course <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="space-y-12">
            <!-- Upcoming Classes -->
            <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-600/20 rounded-full blur-3xl"></div>
                <h3 class="text-lg font-black mb-6 flex items-center gap-2">
                    <i class="bi bi-broadcast text-[#F37021]"></i> Live Sessions
                </h3>
                <div class="space-y-6">
                    @forelse($upcomingClasses as $class)
                    <div class="relative pl-6 border-l-2 border-red-500/30 group">
                        <div class="absolute -left-[5px] top-1 w-2 h-2 rounded-full bg-orange-600"></div>
                        <h4 class="text-sm font-bold text-white mb-1 group-hover:text-[#F37021] transition-colors leading-tight">{{ $class['title'] }}</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $class['time'] }}</p>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500 italic">No classes scheduled today.</p>
                    @endforelse
                </div>
                <button class="w-full mt-10 py-3 bg-[#F37021] hover:bg-[#E6631E] rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                    View Schedule
                </button>
            </div>

            <!-- Top Instructors -->
            <div>
                <h3 class="text-lg font-black text-slate-900 mb-6 px-2">Top Mentors</h3>
                <div class="space-y-1">
                    @foreach($topInstructors as $instructor)
                    <div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-white transition-all group">
                        <img src="{{ $instructor['avatar'] }}" class="w-11 h-11 rounded-xl object-cover shadow-sm group-hover:ring-2 ring-[#F37021] ring-offset-2 transition-all">
                        <div class="flex-1">
                            <div class="text-sm font-bold text-slate-900">{{ $instructor['name'] }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $instructor['courses'] }} Courses</div>
                        </div>
                        <button class="p-2 text-slate-300 hover:text-[#F37021] transition-colors">
                            <i class="bi bi-plus-circle text-xl"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
