@extends('layouts.admin')

@section('title', 'Registered Students')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-[24px] font-[800] text-navy tracking-tight">Student Directory</h1>
            <p class="text-muted mt-1 font-[500] text-[14px]">Manage and monitor all learners registered on the platform</p>
        </div>
        <div class="flex items-center gap-4">
            <span class="px-[20px] py-[12px] bg-white border border-border rounded-[12px] text-[13px] font-[700] text-navy shadow-sm">
                Total Students: <span class="text-primary">{{ $students->total() }}</span>
            </span>
        </div>
    </div>

    <div class="bg-white rounded-[12px] border border-border shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-border/30">
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Identity</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Contact Info</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider text-center">Involvement</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider">Registration</th>
                        <th class="px-[24px] py-[16px] text-[12px] font-[700] text-muted uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($students as $student)
                    <tr class="hover:bg-border/10 transition-colors group">
                        <td class="px-[24px] py-[16px]">
                            <div class="flex items-center gap-[12px]">
                                <div class="w-[40px] h-[40px] rounded-[10px] bg-accent text-primary flex items-center justify-center font-[800] text-[14px]">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-[14px] font-[700] text-navy leading-tight mb-1">{{ $student->name }}</div>
                                    <div class="text-[11px] text-muted font-[600] uppercase tracking-wider">UID: {{ $student->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="text-[13px] font-[600] text-navy mb-1">{{ $student->email }}</div>
                            <div class="text-[11px] text-muted">No phone provided</div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="flex items-center justify-center gap-[24px]">
                                <div class="text-center">
                                    <div class="text-[14px] font-[800] text-navy leading-none mb-1">{{ $student->admissions_count }}</div>
                                    <div class="text-[10px] text-muted font-[700] uppercase tracking-widest">Applied</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-[14px] font-[800] text-emerald-600 leading-none mb-1">{{ $student->enrollments_count }}</div>
                                    <div class="text-[10px] text-muted font-[700] uppercase tracking-widest">Active</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-[24px] py-[16px] text-[12px] font-[600] text-muted uppercase tracking-wider">
                            {{ $student->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-[24px] py-[16px] text-right">
                            <a href="{{ route('admin.admissions.index', ['user_id' => $student->id]) }}" class="text-[12px] font-[800] text-primary uppercase tracking-widest hover:underline">
                                View History
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-[64px] text-center text-muted italic font-[600]">No students registered.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
        <div class="px-[24px] py-[16px] bg-border/20 border-t border-border">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
