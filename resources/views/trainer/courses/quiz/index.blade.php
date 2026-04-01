@extends('layouts.admin')

@section('title', 'Course Assessment Bank')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="relative overflow-hidden rounded-[20px] bg-navy p-8 md:p-10 text-white shadow-2xl">
        <div class="absolute top-[-30px] right-[-30px] w-[250px] h-[250px] bg-primary/20 rounded-full blur-[100px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-[18px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-xl">
                    <i class="bi bi-mortarboard text-primary text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-[900] tracking-tight uppercase">Assessment <span class="text-primary">Bank</span></h1>
                    <p class="text-slate-400 text-[12px] md:text-[14px] font-[600] uppercase tracking-[0.2em] mt-1">{{ $course->title }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('trainer.courses.show', $course->id) }}" class="px-6 py-3 bg-white/5 border border-white/10 text-white font-[900] text-[12px] rounded-[14px] hover:bg-white/10 transition-all uppercase tracking-widest flex items-center gap-3 backdrop-blur-md">
                    <i class="bi bi-arrow-left"></i>
                    <span>Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- New Question Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[24px] border border-border shadow-sm overflow-hidden sticky top-8">
                <div class="p-6 border-b border-border bg-slate-50/50">
                    <h3 class="text-lg font-[900] text-navy uppercase tracking-tight">Record <span class="text-primary">Question</span></h3>
                    <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest mt-1">Enroll a new MCQ into the sequence.</p>
                </div>
                <form action="{{ route('trainer.courses.quiz.store', $course->id) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2 px-1">Institutional Query</label>
                        <textarea name="question" required placeholder="State the question clearly..." 
                                  class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[16px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy placeholder:text-slate-300 resize-none" rows="3"></textarea>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-0 px-1 text-center">Outcome Variants</label>
                        
                        @foreach(['a', 'b', 'c', 'd'] as $opt)
                        <div class="relative group">
                            <input type="text" name="option_{{ $opt }}" required placeholder="Option {{ strtoupper($opt) }}" 
                                   class="w-full pl-14 pr-5 py-4 bg-slate-50 border-2 border-transparent rounded-[16px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[700] text-navy placeholder:text-slate-300">
                            <div class="absolute left-2 top-1/2 -translate-y-1/2 flex items-center gap-2">
                                <label class="w-8 h-8 rounded-[10px] bg-white border-2 border-border flex items-center justify-center text-[12px] font-[900] text-navy group-focus-within:border-primary group-focus-within:text-primary transition-all cursor-pointer">
                                    <input type="radio" name="correct_option" value="{{ $opt }}" class="hidden" {{ $opt == 'a' ? 'checked' : '' }}>
                                    <span class="radio-label">{{ strtoupper($opt) }}</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest text-center py-2 italic border-y border-dashed border-border opacity-60">
                        Mark the target node as the correct response.
                    </p>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-4 bg-navy text-white rounded-[16px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20 active:scale-[0.98]">
                            Encrypt & Save Question
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Question List -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-[900] text-navy uppercase tracking-tight">Active Curriculum Questions ({{ $questions->count() }})</h2>
                <div class="h-1 flex-1 mx-6 bg-slate-100 rounded-full"></div>
            </div>

            @forelse($questions as $index => $q)
            <div class="bg-white rounded-[24px] border border-border shadow-sm p-6 md:p-8 hover:shadow-xl hover:border-primary/20 transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <form action="{{ route('trainer.courses.quiz.destroy', [$course->id, $q->id]) }}" method="POST" onsubmit="return confirm('Purge this record from the assessment bank?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-10 h-10 rounded-full bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-all">
                            <i class="bi bi-trash3 text-lg"></i>
                        </button>
                    </form>
                </div>

                <div class="flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-[14px] bg-slate-100 text-navy font-[900] flex items-center justify-center border border-border group-hover:bg-navy group-hover:text-white transition-all shrink-0">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 space-y-6">
                        <h4 class="text-lg font-[800] text-navy pr-10 leading-relaxed">{{ $q->question }}</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(['a', 'b', 'c', 'd'] as $opt)
                            <div @class([
                                'px-5 py-4 rounded-[16px] text-[14px] font-[700] flex items-center gap-4 border-2 transition-all',
                                'bg-emerald-50 border-emerald-100 text-emerald-700 shadow-sm' => $q->correct_option == $opt,
                                'bg-slate-50 border-transparent text-slate-400 opacity-60' => $q->correct_option != $opt,
                            ])>
                                <span @class([
                                    'w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-[900] uppercase',
                                    'bg-emerald-500 text-white' => $q->correct_option == $opt,
                                    'bg-slate-200 text-slate-500' => $q->correct_option != $opt,
                                ])>{{ $opt }}</span>
                                <span class="capitalize">{{ $q->{"option_$opt"} }}</span>
                                @if($q->correct_option == $opt)
                                    <i class="bi bi-check-circle-fill ml-auto text-emerald-500"></i>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-[24px] border-2 border-dashed border-border p-20 text-center">
                <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mx-auto mb-6 shadow-inner">
                    <i class="bi bi-patch-question text-4xl"></i>
                </div>
                <h3 class="text-xl font-[900] text-navy uppercase tracking-tight mb-2">Populate Exam Vault</h3>
                <p class="text-slate-500 text-[14px] max-w-sm mx-auto font-[500]">Begin adding Multiple Choice Questions to construct the official certification gateway.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    input[type="radio"]:checked + .radio-label {
        color: #ff6b00;
    }
    input[type="radio"]:checked ~ .radio-label, .radio-label:has(input:checked) {
        border-color: #ff6b00;
        color: #ff6b00;
    }
    label:has(input:checked) {
        border-color: #ff6b00 !important;
        background-color: #fffaf5 !important;
        color: #ff6b00 !important;
    }
</style>
@endsection
