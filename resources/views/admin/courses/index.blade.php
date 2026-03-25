@extends('layouts.admin')

@section('title', 'System Courses')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-[24px] font-[800] text-navy tracking-tight">System Courses</h1>
            <p class="text-muted mt-1 font-[500] text-[14px]">Manage the complete catalog of educational programs</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="inline-flex items-center gap-[10px] px-[24px] py-[12px] bg-primary text-white font-[700] rounded-[8px] hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/10 text-[14px]">
            <i class="bi bi-plus-lg"></i> Launch New Course
        </a>
    </div>

    <!-- Stats Preview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Total Courses', 'value' => $courses->total(), 'color' => '#1B365D'],
            ['label' => 'Active Batches', 'value' => '12', 'color' => '#F37021'],
        ] as $stat)
        <div class="bg-white p-[20px] rounded-[12px] border border-border shadow-sm flex items-center gap-[16px]">
            <div class="w-[4px] h-[32px] rounded-full" style="background: {{ $stat['color'] }}"></div>
            <div>
                <div class="text-[20px] font-[800] text-navy leading-none mb-1">{{ $stat['value'] }}</div>
                <div class="text-[12px] font-[600] text-muted uppercase tracking-wider">{{ $stat['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-[12px] border border-border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-border/30">
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Course Identity</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Instructor</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider text-center">Lessons / Students</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Price</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($courses as $course)
                    <tr class="hover:bg-border/10 transition-colors group">
                        <td class="px-[24px] py-[16px] max-w-xs">
                            <div class="text-[14px] font-[700] text-navy group-hover:text-primary transition-colors leading-tight mb-1 truncate">{{ $course->title }}</div>
                            <div class="text-[11px] text-muted font-[600] uppercase tracking-wider">ID: {{ $course->id }}</div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="flex items-center gap-[10px]">
                                <div class="w-[32px] h-[32px] rounded-[8px] bg-accent text-primary flex items-center justify-center font-[800] text-[12px]">
                                    {{ substr($course->instructor_name, 0, 1) }}
                                </div>
                                <div class="text-[13px] font-[700] text-navy leading-none">{{ $course->instructor_name }}</div>
                            </div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="flex items-center justify-center gap-[24px]">
                                <div class="text-center">
                                    <div class="text-[14px] font-[800] text-navy leading-none mb-1">{{ $course->lessons_count }}</div>
                                    <div class="text-[10px] text-muted font-[700] uppercase tracking-widest">Videos</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-[14px] font-[800] text-primary leading-none mb-1">{{ $course->enrollments_count }}</div>
                                    <div class="text-[10px] text-muted font-[700] uppercase tracking-widest">Learners</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="text-[15px] font-[800] text-navy">₹{{ number_format($course->price) }}</div>
                        </td>
                        <td class="px-[24px] py-[16px] text-right">
                            <div class="flex items-center justify-end gap-[12px]">
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="text-muted hover:text-navy transition-colors">
                                    <i class="bi bi-pencil-square text-[20px]"></i>
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Archive this course?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-muted hover:text-red-500 transition-colors">
                                        <i class="bi bi-trash3 text-[20px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-[64px] text-center text-muted font-[600] italic">No courses found in system.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($courses->hasPages())
        <div class="px-[24px] py-[16px] bg-border/20 border-t border-border">
            {{ $courses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
