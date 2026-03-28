@extends('layouts.admin')

@section('title', 'System Courses')

@section('content')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 20px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<div class="space-y-8" x-data="{ 
    courseDetail: null, 
    trainerDetail: null,
    loading: false,
    async fetchCourse(id) {
        this.loading = true;
        this.courseDetail = null;
        this.trainerDetail = null;
        try {
            const resp = await fetch(`/admin/api/courses/${id}`);
            this.courseDetail = await resp.json();
        } catch(e) { console.error(e); }
        this.loading = false;
    },
    async fetchTrainer(name) {
        this.loading = true;
        this.courseDetail = null;
        this.trainerDetail = null;
        try {
            const resp = await fetch(`/admin/api/trainers/courses?name=${encodeURIComponent(name)}`);
            this.trainerDetail = await resp.json();
        } catch(e) { console.error(e); }
        this.loading = false;
    }
}">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-[24px] font-[800] text-navy tracking-tight uppercase">System <span class="text-primary">Catalog</span></h1>
            <p class="text-muted mt-1 font-[500] text-[12px] uppercase tracking-widest">Global educational inventory & performance metrics</p>
        </div>
    </div>

    <!-- Stats Preview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Total Courses', 'value' => $courses->total(), 'color' => '#1B365D', 'icon' => 'bi-journal-bookmark'],
            ['label' => 'Active Sessions', 'value' => '12', 'color' => '#F37021', 'icon' => 'bi-broadcast'],
        ] as $stat)
        <div class="bg-white p-[20px] rounded-[16px] border border-slate-100 shadow-sm flex items-center gap-[20px] group hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-[12px] bg-slate-50 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform" style="color: {{ $stat['color'] }}">
                <i class="bi {{ $stat['icon'] }}"></i>
            </div>
            <div>
                <div class="text-[20px] font-[900] text-navy leading-none mb-1">{{ $stat['value'] }}</div>
                <div class="text-[10px] font-[800] text-muted uppercase tracking-widest">{{ $stat['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-[20px] border border-slate-200 shadow-xl shadow-slate-200/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-[24px] py-[20px] text-[11px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap">Course Protocol</th>
                        <th class="px-[24px] py-[20px] text-[11px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap">Instructor Node</th>
                        <th class="px-[24px] py-[20px] text-[11px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap text-center">Intel Metrics</th>
                        <th class="px-[24px] py-[20px] text-[11px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap">Value Index</th>
                        <th class="px-[24px] py-[20px] text-[11px] font-[900] text-navy uppercase tracking-widest whitespace-nowrap text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($courses as $course)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-[24px] py-[16px] max-w-xs">
                            <button @click="fetchCourse({{ $course->id }})" class="text-[14px] font-[800] text-navy group-hover:text-primary transition-colors leading-tight text-left hover:underline underline-offset-4 decoration-2">
                                {{ $course->title }}
                            </button>
                            <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-[0.2em] mt-1.5 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                PHY-{{ sprintf('%04d', $course->id) }}
                            </div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <button @click="fetchTrainer('{{ addslashes($course->instructor_name) }}')" class="flex items-center gap-[12px] group/item hover:bg-white p-1 pr-3 rounded-full transition-all">
                                <div class="w-[32px] h-[32px] rounded-full bg-navy text-white flex items-center justify-center font-[900] text-[11px] shadow-lg group-hover/item:bg-primary transition-colors">
                                    {{ substr($course->instructor_name, 0, 1) }}
                                </div>
                                <div class="text-[13px] font-[800] text-navy group-hover/item:text-primary transition-colors">{{ $course->instructor_name }}</div>
                            </button>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="flex items-center justify-center gap-[32px]">
                                <div class="text-center">
                                    <div class="text-[14px] font-[900] text-navy leading-none mb-1">{{ $course->lessons_count }}</div>
                                    <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest">Videos</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-[14px] font-[900] text-primary leading-none mb-1">{{ $course->enrollments_count }}</div>
                                    <div class="text-[9px] text-slate-400 font-[800] uppercase tracking-widest">Graduates</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-[24px] py-[16px]">
                            <div class="text-[15px] font-[900] text-navy">₹{{ number_format($course->price) }}</div>
                            <div class="text-[9px] text-emerald-500 font-[900] uppercase tracking-widest mt-1">Settled</div>
                        </td>
                        <td class="px-[24px] py-[16px] text-right">
                            <div class="flex items-center justify-end gap-[12px]">
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="w-9 h-9 flex items-center justify-center bg-slate-50 text-slate-400 rounded-[10px] border border-slate-200 hover:bg-navy hover:text-white hover:border-navy transition-all shadow-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Archive this course?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center bg-slate-50 text-slate-400 rounded-[10px] border border-slate-200 hover:bg-red-50 hover:text-red-500 hover:border-red-100 transition-all shadow-sm">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-[80px] text-center">
                            <i class="bi bi-journal-x text-5xl text-slate-200"></i>
                            <p class="mt-4 text-[11px] font-[900] text-slate-400 uppercase tracking-widest italic">Inventory Protocol: Zero Results</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($courses->hasPages())
        <div class="px-[24px] py-[20px] bg-slate-50/50 border-t border-slate-100">
            {{ $courses->links() }}
        </div>
        @endif
    </div>

    <!-- Modals Overlay -->
    <template x-if="courseDetail || trainerDetail || loading">
        <div class="fixed inset-0 z-[1100] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-navy/80 backdrop-blur-md" @click="courseDetail = null; trainerDetail = null; loading = false"></div>
            
            <div class="relative bg-white w-full max-w-2xl rounded-[24px] overflow-hidden shadow-2xl border border-white/10 animate-in fade-in zoom-in duration-300 max-h-[90vh] flex flex-col">
                <!-- Inner scrollable container -->
                <div class="overflow-y-auto custom-scrollbar flex-1">
                    <!-- Loading State -->
                    <div x-show="loading" class="p-20 text-center">
                        <div class="inline-block w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                        <p class="mt-4 text-[11px] font-[900] text-navy uppercase tracking-widest animate-pulse">Synchronizing Intelligence...</p>
                    </div>

                    <!-- Course Details -->
                    <div x-show="courseDetail && !loading" class="focus:outline-none">
                        <div class="relative h-48 bg-navy">
                            <img :src="courseDetail?.thumbnail" class="w-full h-full object-cover opacity-40">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy to-transparent"></div>
                            <button @click="courseDetail = null" class="absolute top-6 right-6 w-10 h-10 bg-white/10 backdrop-blur-md text-white rounded-full flex items-center justify-center hover:bg-white/20 transition-all">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="p-8 -mt-12 relative z-10">
                            <div class="inline-flex px-4 py-1.5 bg-primary text-white text-[10px] font-[900] uppercase tracking-widest rounded-full shadow-lg shadow-orange-500/20 mb-6">Course Intelligence</div>
                            <h2 class="text-2xl font-[900] text-navy uppercase leading-tight" x-text="courseDetail?.title"></h2>
                            
                            <div class="flex items-center gap-4 mt-4">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-person-badge text-primary"></i>
                                    <span class="text-[12px] font-[800] text-slate-500 uppercase tracking-widest" x-text="courseDetail?.instructor"></span>
                                </div>
                                <div class="w-1.5 h-1.5 bg-slate-200 rounded-full"></div>
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-tag text-emerald-500"></i>
                                    <span class="text-[14px] font-[900] text-navy uppercase" x-text="'₹'+courseDetail?.price"></span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mt-8">
                                <div class="p-4 bg-slate-50 rounded-[16px] border border-slate-100">
                                    <div class="text-[9px] font-[900] text-slate-400 uppercase tracking-widest mb-1">Total Assets</div>
                                    <div class="text-xl font-[900] text-navy" x-text="courseDetail?.lessons + ' Video Modules'"></div>
                                </div>
                                <div class="p-4 bg-slate-50 rounded-[16px] border border-slate-100">
                                    <div class="text-[9px] font-[900] text-slate-400 uppercase tracking-widest mb-1">Institutional Reach</div>
                                    <div class="text-xl font-[900] text-navy" x-text="courseDetail?.students + ' Verified Students'"></div>
                                </div>
                            </div>

                            <div class="mt-8 space-y-6">
                                <div>
                                    <h4 class="text-[11px] font-[900] text-navy uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                                        <i class="bi bi-body-text text-primary"></i> Description
                                    </h4>
                                    <p class="text-[13px] text-slate-600 font-[500] leading-relaxed" x-text="courseDetail?.description"></p>
                                </div>
                                <div>
                                    <h4 class="text-[11px] font-[900] text-navy uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                                        <i class="bi bi-check2-circle text-emerald-500"></i> Learning Outcomes
                                    </h4>
                                    <div class="text-[13px] text-slate-600 font-[500] leading-relaxed" x-text="courseDetail?.outcomes"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trainer Catalog -->
                    <div x-show="trainerDetail && !loading" class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-navy text-white flex items-center justify-center text-xl font-[900] shadow-xl">
                                    <span x-text="trainerDetail?.trainer?.substring(0,1)"></span>
                                </div>
                                <div>
                                    <h2 class="text-xl font-[900] text-navy uppercase leading-none" x-text="trainerDetail?.trainer"></h2>
                                    <p class="text-[10px] text-slate-400 font-[800] uppercase tracking-widest mt-2 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                                        Senior Education Trainer
                                    </p>
                                </div>
                            </div>
                            <button @click="trainerDetail = null" class="w-10 h-10 bg-slate-50 text-navy rounded-full flex items-center justify-center hover:bg-slate-100 transition-all border border-slate-100">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <h4 class="text-[11px] font-[900] text-navy uppercase tracking-[0.2em] mb-4 flex items-center justify-between">
                                Assigned Product Catalog 
                                <span class="text-primary" x-text="trainerDetail?.courses?.length + ' Courses'"></span>
                            </h4>
                            
                            <div class="space-y-3">
                                <template x-for="course in trainerDetail?.courses" :key="course.id">
                                    <div class="p-4 bg-slate-50 rounded-[16px] border border-slate-100 flex items-center justify-between group hover:bg-white hover:border-primary/20 transition-all cursor-default">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-navy font-[900] text-xs shadow-sm border border-slate-100 group-hover:bg-navy group-hover:text-white transition-all" x-text="course.lessons"></div>
                                            <div>
                                                <div class="text-sm font-[800] text-navy truncate max-w-[200px]" x-text="course.title"></div>
                                                <div class="text-[9px] text-slate-400 font-[700] uppercase tracking-widest mt-0.5" x-text="'PHY-'+course.id.toString().padStart(4, '0')"></div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[13px] font-[900] text-navy" x-text="'₹'+course.price"></div>
                                            <div class="text-[8px] text-emerald-500 font-[900] uppercase tracking-widest">Active</div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-50">
                            <div class="flex items-center justify-between text-[11px] font-[800] text-slate-400 uppercase tracking-widest">
                                <span>Total Portfolio Valuation</span>
                                <span class="text-navy" x-text="'₹'+trainerDetail?.courses?.reduce((acc, c) => acc + parseFloat(c.price.replace(/,/g, '')), 0).toLocaleString()"></span>
                            </div>
                        </div>
                    </div>
                </div> <!-- End of overflow-y-auto -->
            </div> <!-- End of relative bg-white -->
        </div> <!-- End of fixed overlay -->
    </template>
</div>
@endsection
