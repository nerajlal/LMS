@extends('layouts.admin')

@section('title', 'Institutional Course Feedback')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-8 md:p-10 text-white shadow-2xl">
        <div class="absolute top-[-30px] right-[-30px] w-[250px] h-[250px] bg-primary/20 rounded-full blur-[100px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-[18px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-xl">
                    <i class="bi bi-chat-dots-fill text-primary text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-[900] tracking-tight uppercase">Feedback <span class="text-primary">Console</span></h1>
                    <p class="text-slate-400 text-[12px] md:text-[14px] font-[600] uppercase tracking-[0.2em] mt-1">{{ $course->title }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.courses.index') }}" class="px-6 py-3 bg-white/5 border border-white/10 text-white font-[900] text-[12px] rounded-[14px] hover:bg-white/10 transition-all uppercase tracking-widest flex items-center gap-3 backdrop-blur-md">
                    <i class="bi bi-arrow-left"></i>
                    <span>Manage Catalog</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Feedback Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[20px] border border-border shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-[14px] bg-primary/10 text-primary flex items-center justify-center text-xl">
                <i class="bi bi-star-fill"></i>
            </div>
            <div>
                <div class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest leading-none mb-1">Average</div>
                <div class="text-2xl font-[900] text-navy leading-none">{{ number_format($feedbacks->avg('rating'), 1) }}</div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[20px] border border-border shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-[14px] bg-navy/5 text-navy flex items-center justify-center text-xl text-navy/40">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div>
                <div class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest leading-none mb-1">Students</div>
                <div class="text-2xl font-[900] text-navy leading-none">{{ $feedbacks->count() }}</div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[20px] border border-border shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-[14px] bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl">
                <i class="bi bi-emoji-smile-fill"></i>
            </div>
            <div>
                <div class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest leading-none mb-1">Satisfied</div>
                <div class="text-2xl font-[900] text-navy leading-none">{{ $feedbacks->where('rating', '>=', 4)->count() }}</div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[20px] border border-border shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-[14px] bg-rose-50 text-rose-500 flex items-center justify-center text-xl">
                <i class="bi bi-flag-fill"></i>
            </div>
            <div>
                <div class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest leading-none mb-1">Concerns</div>
                <div class="text-2xl font-[900] text-navy leading-none">{{ $feedbacks->where('rating', '<=', 2)->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Feedback List -->
    <div class="space-y-6">
        @forelse($feedbacks as $fb)
        <div class="bg-white rounded-[24px] border border-border shadow-sm p-6 md:p-8 hover:shadow-xl hover:border-primary/10 transition-all group overflow-hidden relative">
            <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="bi bi-chat-quote-fill text-6xl text-navy"></i>
            </div>

            <div class="flex flex-col md:flex-row gap-8 items-start relative z-10">
                <div class="flex flex-col items-center gap-3 shrink-0">
                    <div class="w-16 h-16 rounded-[20px] border-2 border-slate-100 p-1 bg-white shadow-sm overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($fb->user->name) }}&background=1B365D&color=fff" class="w-full h-full object-cover rounded-[14px]">
                    </div>
                </div>

                <div class="flex-1 space-y-4 pt-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-[15px] font-[900] text-navy leading-none mb-1">{{ $fb->user->name }}</div>
                            <div class="text-[10px] font-[700] text-slate-400 uppercase tracking-widest leading-none">{{ $fb->user->email }}</div>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center gap-1.5 mb-1 justify-end">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $fb->rating ? 'bi-star-fill text-primary' : 'bi-star text-slate-200' }} text-[12px]"></i>
                                @endfor
                            </div>
                            <div class="text-[9px] font-[800] text-slate-300 uppercase tracking-widest">{{ $fb->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    <div class="h-px w-full bg-slate-50"></div>

                    <p class="text-slate-600 font-[500] text-[15px] leading-relaxed italic max-w-4xl">
                        "{{ $fb->comment ?: 'Student provided rating without specific textual feedback.' }}"
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-[24px] border-2 border-dashed border-border p-20 text-center shadow-inner">
            <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mx-auto mb-6 shadow-inner animate-pulse">
                <i class="bi bi-chat-left-dots text-4xl"></i>
            </div>
            <h3 class="text-xl font-[900] text-navy uppercase tracking-tight mb-2">Awaiting Student Feedback</h3>
            <p class="text-slate-500 text-[14px] max-w-sm mx-auto font-[500]">Insights and ratings for this curriculum will appear here as students graduate.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
