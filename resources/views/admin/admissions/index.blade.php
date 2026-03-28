@extends('layouts.admin')

@section('title', 'Enrollment & Graduation - Admin')

@section('content')
<div class="space-y-8" x-data="{ activeTab: '{{ request('tab', 'approved') }}' }">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-person-check text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase leading-none">Admission <span class="text-primary">Console</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-2">Manage student lifecycles and certifications</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2 p-1 bg-white/5 border border-white/10 rounded-[14px] backdrop-blur-sm">
                <button @click="activeTab = 'approved'" :class="activeTab === 'approved' ? 'bg-primary text-white shadow-lg' : 'text-slate-400 hover:text-white'" class="px-5 py-2 rounded-[10px] text-[10px] font-[900] uppercase tracking-widest transition-all">Active</button>
                <button @click="activeTab = 'completed'" :class="activeTab === 'completed' ? 'bg-primary text-white shadow-lg' : 'text-slate-400 hover:text-white'" class="px-5 py-2 rounded-[10px] text-[10px] font-[900] uppercase tracking-widest transition-all uppercase">Completed</button>
            </div>
        </div>
    </div>

    <!-- Data Table Console -->
    <div class="bg-white rounded-[20px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden">
        <div class="overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap">Identity Node</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap hidden lg:table-cell">Product Path</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap text-center">Status Index</th>
                        <th class="p-5 text-[10px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap text-right">Protocol Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($admissions as $admission)
                    @php
                        $tabCategory = 'pending';
                        if($admission->status === 'approved') {
                            $tabCategory = ($admission->progress >= 100) ? 'completed' : 'approved';
                        }
                    @endphp
                    <tr x-show="activeTab === '{{ $tabCategory }}'" x-transition class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-5 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-[10px] bg-navy/5 flex items-center justify-center text-navy shrink-0 border border-navy/5 group-hover:bg-navy group-hover:text-white transition-all uppercase font-bold text-xs ring-2 ring-transparent group-hover:ring-primary/20">
                                    {{ substr($admission->user->name, 0, 2) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-[13px] font-[800] text-navy truncate group-hover:text-primary transition-colors">{{ $admission->user->name }}</div>
                                    <div class="text-[10px] text-slate-500 font-[600] uppercase tracking-wider mt-0.5">{{ $admission->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 hidden lg:table-cell">
                            <div class="text-[13px] font-[800] text-navy leading-tight line-clamp-1 italic text-slate-600 border-l-2 border-primary/20 pl-3 leading-none truncate max-w-[200px]">{{ $admission->course->title ?? 'General Program' }}</div>
                            <div class="mt-2 ml-3">
                                @if($tabCategory === 'completed')
                                    <span class="text-[10px] text-slate-500 font-[800] uppercase tracking-widest bg-slate-100 px-3 py-1 rounded-[6px] border border-slate-200 inline-flex items-center gap-1.5 shadow-inner">
                                        <i class="bi bi-person-check text-primary"></i> {{ $admission->batch?->name ?? 'No Batch Assignment' }}
                                    </span>
                                @else
                                    <form action="{{ route('admin.admissions.assign-batch', $admission->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="batch_id" onchange="this.form.submit()" class="text-[10px] text-navy font-[800] uppercase tracking-widest bg-slate-50 border border-slate-200 px-2 py-1 rounded-[6px] focus:ring-1 focus:ring-primary focus:border-primary transition-all cursor-pointer max-w-[150px]">
                                            <option value="">No Batch Assignment</option>
                                            @foreach($batches->where('course_id', $admission->course_id) as $batch)
                                                <option value="{{ $batch->id }}" {{ $admission->batch_id == $batch->id ? 'selected' : '' }}>
                                                    {{ $batch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                @endif
                            </div>
                        </td>
                        <td class="p-5 text-center whitespace-nowrap">
                            @php
                                $statusStyles = [
                                    'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100 shadow-emerald-100/50',
                                    'pending'  => 'bg-amber-50 text-amber-600 border-amber-100 shadow-amber-100/50',
                                    'rejected' => 'bg-pink-50 text-pink-600 border-pink-100 shadow-pink-100/50',
                                ];
                                $style = $statusStyles[$admission->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                            @endphp
                            <span class="px-3 py-1.5 {{ $style }} rounded-full text-[9px] font-[900] uppercase tracking-widest border shadow-sm">
                                {{ $admission->status }}
                            </span>
                            @if($admission->status === 'approved')
                                <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest mt-2">{{ $admission->progress ?? 0 }}% Mastery</div>
                            @else
                                <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest mt-2 uppercase leading-none">{{ $admission->created_at->format('d M Y') }}</div>
                            @endif
                        </td>
                        <td class="p-5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                @if($admission->status === 'pending')
                                    <form action="{{ route('admin.admissions.approve', $admission->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="h-9 px-5 bg-emerald-600 text-white text-[10px] font-[900] uppercase tracking-widest rounded-[10px] hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 border border-emerald-500">
                                            Authorize
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.admissions.reject', $admission->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="h-9 px-5 bg-white text-navy text-[10px] font-[900] uppercase tracking-widest rounded-[10px] border border-slate-200 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 transition-all">
                                            Deny
                                        </button>
                                    </form>
                                @elseif($admission->progress >= 100)
                                    @if($admission->certificate_path)
                                        <a href="{{ asset('storage/' . $admission->certificate_path) }}" target="_blank" class="h-9 px-5 bg-navy text-white text-[10px] font-[900] uppercase tracking-widest rounded-[10px] flex items-center gap-2 hover:bg-primary transition-all shadow-lg border border-navy shadow-navy/20">
                                            <i class="bi bi-file-earmark-pdf"></i> View Diploma
                                        </a>
                                        <button onclick="document.getElementById('upload-{{ $admission->id }}').click()" class="w-9 h-9 bg-slate-50 text-slate-500 rounded-[10px] flex items-center justify-center border border-slate-200 hover:bg-slate-100 transition-all" title="Update Diploma">
                                            <i class="bi bi-arrow-repeat text-lg"></i>
                                        </button>
                                    @else
                                        <button onclick="document.getElementById('upload-{{ $admission->id }}').click()" class="h-9 px-5 bg-primary text-white text-[10px] font-[900] uppercase tracking-widest rounded-[10px] flex items-center gap-2 hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 shadow-lg border border-primary">
                                            <i class="bi bi-award"></i> Issue Certificate
                                        </button>
                                    @endif
                                    
                                    <form id="form-{{ $admission->id }}" action="{{ route('admin.admissions.certificate', $admission->id) }}" method="POST" enctype="multipart/form-data" class="hidden">
                                        @csrf
                                        <input type="file" id="upload-{{ $admission->id }}" name="certificate" onchange="document.getElementById('form-{{ $admission->id }}').submit()" accept=".pdf,.jpg,.jpeg,.png">
                                    </form>
                                @else
                                    <div class="px-5 py-2 bg-slate-50 border border-slate-100 rounded-[10px] text-[10px] font-[800] text-slate-400 uppercase tracking-widest italic shadow-inner">Learning in Progress</div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-24 text-center">
                            <div class="flex flex-col items-center gap-4 opacity-30">
                                <i class="bi bi-clipboard text-6xl text-navy"></i>
                                <p class="text-[10px] font-[900] text-navy uppercase tracking-[0.2em]">No registry entries found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($admissions->hasPages())
    <div class="mt-6">
        {{ $admissions->links() }}
    </div>
    @endif
</div>
@endsection
