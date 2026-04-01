@extends('layouts.app')

@section('title', $course->title . ' - Final Examination')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6" x-data="{ 
    currentStep: 0, 
    totalSteps: {{ $questions->count() }},
    answers: {},
    confirmSubmit: false,
    selectOption(qid, opt) {
        this.answers[qid] = opt;
    },
    isAnswered(qid) {
        return this.answers[qid] !== undefined;
    },
    allAnswered() {
        return Object.keys(this.answers).length === this.totalSteps;
    }
}">
    <!-- Exam Header -->
    <div class="mb-12 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-navy text-white flex items-center justify-center shadow-lg border border-white/10">
                <i class="bi bi-mortarboard text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-[900] text-navy uppercase leading-tight">{{ $course->title }}</h1>
                <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest mt-1">Final Knowledge Assessment Protocol.</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3 px-6 py-3 bg-slate-100 rounded-full border border-slate-200 shadow-inner">
            <span class="text-[11px] font-[900] text-navy uppercase tracking-widest">Progress</span>
            <div class="w-32 h-2 bg-slate-200 rounded-full overflow-hidden">
                <div class="h-full bg-primary transition-all duration-500" :style="'width: ' + ((currentStep + 1) / totalSteps * 100) + '%'"></div>
            </div>
            <span class="text-[13px] font-[900] text-primary" x-text="(currentStep + 1) + '/' + totalSteps"></span>
        </div>
    </div>

    <!-- Exam Content -->
    <form action="{{ route('courses.exam.submit', $course->id) }}" method="POST">
        @csrf
        
        @foreach($questions as $index => $q)
        <div x-show="currentStep === {{ $index }}" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-x-10" 
             x-transition:enter-end="opacity-100 translate-x-0"
             class="bg-white rounded-[32px] border border-border shadow-2xl p-8 md:p-12">
            
            <div class="mb-10">
                <span class="text-[10px] font-[900] text-primary uppercase tracking-[0.3em] mb-3 block">Question {{ $index + 1 }} of {{ $questions->count() }}</span>
                <h2 class="text-2xl md:text-3xl font-[800] text-navy leading-tight">{{ $q->question }}</h2>
            </div>

            <div class="grid grid-cols-1 gap-5">
                @foreach(['a', 'b', 'c', 'd'] as $opt)
                <label class="relative group cursor-pointer">
                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" 
                           class="hidden peer" 
                           @click="selectOption({{ $q->id }}, '{{ $opt }}')">
                    
                    <div class="p-6 rounded-[24px] border-2 border-slate-100 bg-slate-50 transition-all duration-300 flex items-center gap-5 group-hover:border-primary/20 peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:shadow-xl peer-checked:shadow-primary/10">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-[14px] font-[900] text-navy uppercase transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary">
                            {{ $opt }}
                        </div>
                        <span class="text-lg font-[700] text-navy peer-checked:text-primary transition-colors">
                            {{ $q->{"option_$opt"} }}
                        </span>
                        <div class="ml-auto opacity-0 peer-checked:opacity-100 transition-opacity">
                            <i class="bi bi-check-circle-fill text-primary text-xl"></i>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>

            <div class="mt-12 flex items-center justify-between pt-8 border-t border-border">
                <button type="button" 
                        @click="currentStep--" 
                        x-show="currentStep > 0"
                        class="px-8 py-4 text-navy font-[900] text-[13px] uppercase tracking-widest hover:text-primary transition-colors flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Previous
                </button>
                <div x-show="currentStep === 0" class="flex-1"></div>

                <div class="flex items-center gap-4">
                    <button type="button" 
                            @click="currentStep++" 
                            x-show="currentStep < totalSteps - 1"
                            :disabled="!isAnswered({{ $q->id }})"
                            class="px-10 py-5 bg-navy text-white rounded-[20px] font-[900] text-[13px] uppercase tracking-[0.2em] shadow-xl shadow-navy/20 active:scale-[0.98] transition-all disabled:opacity-50 disabled:grayscale disabled:cursor-not-allowed">
                        Next <i class="bi bi-arrow-right ml-2 text-lg"></i>
                    </button>

                    <button type="button" 
                            @click="confirmSubmit = true"
                            x-show="currentStep === totalSteps - 1"
                            :disabled="!isAnswered({{ $q->id }})"
                            class="px-10 py-5 bg-primary text-white rounded-[20px] font-[900] text-[13px] uppercase tracking-[0.2em] shadow-xl shadow-orange-500/20 active:scale-[0.98] transition-all disabled:opacity-50">
                        Finish Exam <i class="bi bi-flag ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Submit Confirmation Overlay -->
        <template x-if="confirmSubmit">
            <div class="fixed inset-0 z-[100] flex items-center justify-center p-6">
                <div class="absolute inset-0 bg-navy/80 backdrop-blur-md" @click="confirmSubmit = false"></div>
                <div class="relative bg-white w-full max-w-md rounded-[32px] p-10 text-center shadow-2xl animate-in zoom-in duration-300">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="bi bi-send-check text-4xl text-primary"></i>
                    </div>
                    <h3 class="text-2xl font-[900] text-navy uppercase tracking-tight mb-4">Complete Assessment?</h3>
                    <p class="text-slate-500 font-[500] mb-10">You have completed <span class="font-[800] text-navy" x-text="totalSteps"></span> questions. Your results will be permanently recorded and visible to institutional administrators.</p>
                    
                    <div class="flex flex-col gap-4">
                        <button type="submit" class="w-full py-5 bg-primary text-white rounded-[20px] font-[900] text-[13px] uppercase tracking-[0.2em] shadow-xl shadow-orange-500/20 hover:bg-orange-600 transition-all">
                            Submit Answers
                        </button>
                        <button type="button" @click="confirmSubmit = false" class="w-full py-4 text-slate-400 font-[900] text-[12px] uppercase tracking-widest hover:text-navy transition-colors">
                            Return to Exam
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </form>
</div>
@endsection
