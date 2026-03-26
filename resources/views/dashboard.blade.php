@extends('layouts.app')

@section('title', 'Student Dashboard - The Ace India')

@section('content')
<div class="space-y-8">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $statCards = [
                ['label' => 'Completed', 'value' => $stats['completed'], 'icon' => 'bi-briefcase', 'color' => '#1B365D'],
                ['label' => 'Wishlist', 'value' => $stats['wishlist'], 'icon' => 'bi-heart', 'color' => '#F37021'],
                ['label' => 'Certification', 'value' => $stats['certifications'], 'icon' => 'bi-award', 'color' => '#F37021'],
                ['label' => 'Purchased', 'value' => $stats['enrolled'], 'icon' => 'bi-cart', 'color' => '#1B365D'],
            ];
        @endphp

        @foreach($statCards as $card)
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
        <!-- Courses in Progress -->
        <div class="lg:col-span-8 flex flex-col">
            <div class="bg-white rounded-[12px] border border-border overflow-hidden h-full">
                <div class="p-[24px] border-b border-border flex justify-between items-center">
                    <h2 class="text-[18px] font-[800] text-navy">Courses in progress</h2>
                    <a href="{{ route('courses.index') }}" class="text-[#F37021] text-[13px] font-[700] hover:underline">See all</a>
                </div>
                <div class="p-[0_24px]">
                    @forelse($enrolledCourses as $course)
                    <div class="flex items-center gap-[20px] py-[16px] border-b border-border last:border-0 group">
                        <div class="w-[80px] h-[56px] rounded-[8px] overflow-hidden shrink-0 bg-border">
                            <img src="{{ $course['thumbnail'] ?: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&q=80&w=200' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <div class="text-navy font-[700] text-[15px] mb-[6px] truncate">{{ $course['title'] }}</div>
                            <div class="flex items-center gap-[12px]">
                                <div class="text-[12px] text-muted whitespace-nowrap">{{ round($course['progress']/10) }}/10 Complete</div>
                                <div class="flex-1 h-[4px] bg-border rounded-full overflow-hidden">
                                    <div class="h-full bg-primary transition-all duration-500" style="width: {{ $course['progress'] }}%"></div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('courses.show', $course['id']) }}" class="bg-border text-navy px-[16px] py-[8px] rounded-[6px] text-[13px] font-[700] hover:bg-navy hover:text-white transition-all">Resume</a>
                    </div>
                    @empty
                    <div class="py-[48px] text-center">
                        <div class="text-muted text-[14px]">No courses in progress</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Top Instructors -->
            <div class="bg-white rounded-[12px] border border-border overflow-hidden">
                <div class="p-[24px] border-b border-border">
                    <h2 class="text-[18px] font-[800] text-navy">Top Instructors</h2>
                </div>
                <div class="p-[0_24px] py-1">
                    @forelse($topInstructors as $instructor)
                    <div class="flex items-center gap-[12px] py-[12px]">
                        <img src="{{ $instructor['avatar'] }}" class="w-[40px] h-[40px] rounded-full border border-border">
                        <div class="flex-1">
                            <div class="text-navy font-[700] text-[14px]">{{ $instructor['name'] }}</div>
                            <div class="text-muted text-[12px]">{{ $instructor['courses'] }} Courses</div>
                        </div>
                        <button class="bg-white border border-border px-[12px] py-[4px] rounded-[6px] text-[12px] font-[700] text-navy hover:bg-border transition-all">Follow</button>
                    </div>
                    @empty
                    <div class="py-[24px] text-center text-slate-400 text-[13px]">No instructors available.</div>
                    @endforelse
                </div>
                <div class="p-[16px_24px] text-center border-t border-border">
                    <a href="#" class="text-[#F37021] text-[14px] font-[700] hover:underline">See all</a>
                </div>
            </div>

            <!-- Upcoming Live Classes -->
            <div class="bg-white rounded-[12px] border border-border overflow-hidden">
                <div class="p-[20px]">
                    <h3 class="text-[16px] font-[800] text-navy mb-[16px]">Upcoming Live Classes</h3>
                    <div class="flex flex-col gap-[12px]">
                        @forelse($upcomingClasses->take(2) as $cls)
                        <div class="flex gap-[12px] items-center">
                            <div class="w-[40px] h-[40px] rounded-[8px] bg-[#eff6ff] flex items-center justify-center shrink-0">
                                <i class="bi bi-camera-video text-primary"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-[13px] font-[700] text-navy truncate">{{ $cls['title'] }}</div>
                                <div class="text-[11px] text-muted">{{ $cls['time'] }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-[12px] text-slate-400 italic">No classes scheduled.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
