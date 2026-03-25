@extends('layouts.admin')

@section('title', 'System Courses')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">System Courses</h1>
            <p class="text-slate-500 mt-1 font-medium italic">Manage the complete catalog of educational programs</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-[#F37021] text-white font-black rounded-2xl hover:bg-[#E6631E] transition-all shadow-xl shadow-orange-500/20 text-xs uppercase tracking-widest">
            <i class="bi bi-plus-circle-fill text-base"></i> Launch New Course
        </a>
    </div>

    <!-- Stats Preview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Total Courses', 'value' => $courses->total(), 'color' => 'bg-white'],
            ['label' => 'Active Batches', 'value' => '12', 'color' => 'bg-white'],
        ] as $stat)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm transition-transform hover:-translate-y-1">
            <div class="text-xl font-black text-slate-900 leading-none mb-1">{{ $stat['value'] }}</div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Identity</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Instructor</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-center">Stats</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">Price</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($courses as $course)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-6 max-w-xs">
                            <div class="text-sm font-bold text-slate-900 group-hover:text-[#F37021] transition-colors leading-tight mb-2 line-clamp-1">{{ $course->title }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">ID: {{ $course->id }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-[#F37021] font-black text-[10px] border border-white">
                                    {{ substr($course->instructor_name, 0, 1) }}
                                </div>
                                <div class="text-[11px] font-bold text-slate-600 uppercase tracking-widest leading-none">{{ $course->instructor_name }}</div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-6">
                                <div class="text-center">
                                    <div class="text-xs font-black text-slate-900 leading-none mb-1">{{ $course->lessons_count }}</div>
                                    <div class="text-[8px] text-slate-400 font-black uppercase tracking-widest">Lessons</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-xs font-black text-[#F37021] leading-none mb-1">{{ $course->enrollments_count }}</div>
                                    <div class="text-[8px] text-slate-400 font-black uppercase tracking-widest">Enrolled</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-sm font-black text-slate-900">₹{{ number_format($course->price) }}</div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i class="bi bi-pencil-square text-xl"></i>
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Archive this course?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                        <i class="bi bi-trash3 text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <p class="text-slate-400 font-bold italic">No courses found in system.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($courses->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
            {{ $courses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
