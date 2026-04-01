@extends('layouts.app')

@section('title', 'Examination Result - ' . $course->title)

@section('content')
<div class="max-w-2xl mx-auto py-20 px-6 text-center">
    @if($result->status === 'passed')
        <div class="mb-12 animate-in zoom-in duration-700">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl shadow-emerald-500/10 border border-emerald-200 relative">
                <i class="bi bi-patch-check-fill text-5xl text-emerald-500"></i>
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg border border-slate-100 animate-pulse">
                    <i class="bi bi-hourglass-split text-navy"></i>
                </div>
            </div>
            <h1 class="text-4xl font-[900] text-navy uppercase tracking-tight mb-4">Assessment <span class="text-emerald-500">Validated</span></h1>
            <p class="text-slate-500 font-[500] max-w-sm mx-auto">Your institutional score has been recorded. The administration is now **processing your certificate**.</p>
        </div>
    @else
        <div class="mb-12 animate-in zoom-in duration-700">
            <div class="w-24 h-24 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl shadow-rose-500/10 border border-rose-200">
                <i class="bi bi-exclamation-octagon-fill text-5xl text-rose-500"></i>
            </div>
            <h1 class="text-4xl font-[900] text-navy uppercase tracking-tight mb-4">Assessment <span class="text-rose-500">Failed</span></h1>
            <p class="text-slate-500 font-[500] max-w-sm mx-auto">You did not reach the minimum institutional passing threshold of 70%. Review the course material and try again.</p>
        </div>
    @endif

    <!-- Score Card -->
    <div class="bg-white rounded-[32px] border border-border shadow-2xl p-10 mb-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <i class="bi bi-graph-up-arrow text-[120px] text-navy"></i>
        </div>
        
        <div class="grid grid-cols-2 gap-8 relative z-10">
            <div class="text-center border-r border-slate-100">
                <div class="text-[11px] font-[900] text-slate-400 uppercase tracking-widest mb-2">Final Score</div>
                <div @class([
                    'text-5xl font-[900]',
                    'text-emerald-500' => $result->status === 'passed',
                    'text-rose-500' => $result->status === 'failed',
                ])>{{ number_format($result->score) }}%</div>
            </div>
            <div class="text-center">
                <div class="text-[11px] font-[900] text-slate-400 uppercase tracking-widest mb-2">Accuracy</div>
                <div class="text-5xl font-[900] text-navy">{{ $result->total_correct }}/{{ $result->total_questions }}</div>
            </div>
        </div>

        @if($result->status === 'passed')
        @php
            $hasFeedback = \App\Models\CourseFeedback::where('user_id', auth()->id())->where('course_id', $course->id)->exists();
        @endphp

        <div class="mt-12 pt-12 border-t border-slate-100 space-y-8 animate-in slide-in-from-bottom duration-1000">
            @if(!$hasFeedback)
            <div class="bg-slate-50/50 rounded-[24px] p-8 md:p-10 border border-slate-100 shadow-inner">
                <h3 class="text-xl font-[900] text-navy uppercase tracking-tight mb-2">How was your <span class="text-primary">Experience?</span></h3>
                <p class="text-slate-500 font-[500] text-sm mb-8">Your feedback helps us refine the curriculum and institutional standards.</p>
                
                <form action="{{ route('student.feedback.store', $course->id) }}" method="POST" x-data="{ rating: 0 }">
                    @csrf
                    <input type="hidden" name="rating" :value="rating" required>
                    
                    <div class="flex items-center justify-center gap-4 mb-8">
                        <template x-for="i in 5">
                            <button type="button" @click="rating = i" class="text-3xl transition-all duration-300 transform hover:scale-125" :class="rating >= i ? 'text-primary' : 'text-slate-200'">
                                <i :class="rating >= i ? 'bi bi-star-fill' : 'bi bi-star'"></i>
                            </button>
                        </template>
                    </div>

                    <div class="mb-6">
                        <textarea name="comment" placeholder="Share your thoughts on the course material and instructor..." 
                                  class="w-full px-6 py-4 bg-white border-2 border-transparent rounded-[16px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy placeholder:text-slate-300 resize-none" rows="3"></textarea>
                    </div>

                    <button type="submit" :disabled="rating === 0" 
                            class="w-full py-4 bg-navy text-white rounded-[16px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20 disabled:opacity-50 disabled:cursor-not-allowed">
                        Submit Appreciation
                    </button>
                </form>
            </div>
            @else
            <div class="bg-emerald-50/50 rounded-[24px] p-8 border border-emerald-100 text-center">
                <i class="bi bi-heart-fill text-emerald-500 text-2xl mb-3 block"></i>
                <p class="text-emerald-700 font-[800] text-sm uppercase tracking-widest">Feedback Recorded. Thank you for your support.</p>
            </div>
            @endif

            <div class="mt-8 pt-8 border-t border-slate-50">
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-emerald-50 text-emerald-600 rounded-full text-[12px] font-[900] uppercase tracking-widest border border-emerald-100">
                    <i class="bi bi-patch-check"></i>
                    Certification in Progress
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="flex flex-col md:flex-row items-center justify-center gap-6">
        @if($result->status === 'passed')
            <a href="{{ route('courses.show', $course->id) }}" class="px-12 py-5 bg-navy text-white rounded-[20px] font-[900] text-[13px] uppercase tracking-[0.2em] shadow-xl shadow-navy/20 hover:bg-primary transition-all active:scale-[0.98] w-full md:w-auto">
                Return to Course <i class="bi bi-arrow-right ml-2 text-lg"></i>
            </a>
        @else
            <a href="{{ route('courses.exam.show', $course->id) }}" class="px-12 py-5 bg-navy text-white rounded-[20px] font-[900] text-[13px] uppercase tracking-[0.2em] shadow-xl shadow-navy/20 hover:bg-primary transition-all active:scale-[0.98] w-full md:w-auto">
                Retake Exam <i class="bi bi-arrow-clockwise ml-2 text-lg"></i>
            </a>
            <a href="{{ route('courses.show', $course->id) }}" class="px-12 py-5 bg-white text-navy border border-slate-200 rounded-[20px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-slate-50 transition-all w-full md:w-auto">
                Review Lessons
            </a>
        @endif
    </div>

    <p class="mt-12 text-[10px] text-slate-400 font-[800] uppercase tracking-[0.3em] opacity-40">Educational Integrity Protocol Enabled.</p>
</div>
@endsection
