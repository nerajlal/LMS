@extends('layouts.app')

@section('title', 'Course Enrollment - The Ace India')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl overflow-hidden flex flex-col md:flex-row">
        <!-- Sidebar Branding -->
        <div class="w-full md:w-80 bg-navy p-12 text-white relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-primary rounded-[12px] flex items-center justify-center text-white text-2xl font-black mb-10 shadow-lg shadow-orange-500/20">A</div>
                <h2 class="text-[28px] font-[900] tracking-tighter leading-[1.1] mb-6">Start Your <br><span class="text-primary">Journey</span></h2>
                <p class="text-[13px] text-slate-300 font-[500] leading-relaxed mb-12">Join thousands of students and master your future with industry-leading experts.</p>
            </div>
            
            <div class="relative z-10 space-y-6">
                <div class="flex items-center gap-3 text-[10px] font-[800] text-slate-400 tracking-[0.2em] uppercase">
                    <i class="bi bi-shield-check text-primary text-sm"></i> Secure Enrollment
                </div>
            </div>
        </div>

        <!-- Form Area -->
        <div class="flex-1 p-10 lg:p-14 relative bg-white">
            <div class="absolute top-0 right-0 p-8">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-primary animate-pulse"></div>
                    <span class="text-[10px] font-[900] text-slate-400 uppercase tracking-[0.2em]">Application Form</span>
                </div>
            </div>

            <form action="{{ route('admissions.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6" 
                     x-data="{ 
                        selectedCourse: '{{ request('course_id', '') }}',
                        batches: @js($batches),
                        get filteredBatches() {
                            return this.batches.filter(b => b.course_id == this.selectedCourse);
                        }
                     }">
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-[900] text-navy uppercase tracking-[0.15em] mb-3 ml-1">Select Your Course</label>
                        <div class="relative group">
                            <select name="course_id" required x-model="selectedCourse" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[12px] focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary/20 transition-all text-[14px] font-[700] appearance-none cursor-pointer text-navy">
                                <option value="">-- Choose Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-muted text-sm pointer-events-none group-hover:text-primary transition-colors"></i>
                        </div>
                        @error('course_id') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2" x-show="filteredBatches.length > 0" x-transition>
                        <label class="block text-[11px] font-[900] text-navy uppercase tracking-[0.15em] mb-3 ml-1">Preferred Batch</label>
                        <div class="relative group">
                            <select name="batch_id" required class="w-full px-5 py-4 bg-emerald-50/30 border border-emerald-100 rounded-[12px] focus:ring-4 focus:ring-emerald-500/5 focus:bg-white focus:border-emerald-500/20 transition-all text-[14px] font-[700] appearance-none cursor-pointer text-navy italic">
                                <option value="">-- Select Your Batch --</option>
                                <template x-for="batch in filteredBatches" :key="batch.id">
                                    <option :value="batch.id" x-text="batch.name"></option>
                                </template>
                            </select>
                            <i class="bi bi-people absolute right-5 top-1/2 -translate-y-1/2 text-emerald-500 text-sm pointer-events-none group-hover:scale-110 transition-transform"></i>
                        </div>
                        <p class="mt-3 text-[10px] font-[700] text-emerald-600 uppercase tracking-widest px-1"><i class="bi bi-info-circle mr-1"></i> Selection required for live class access</p>
                    </div>

                    <div>
                        <label class="block text-[11px] font-[900] text-navy uppercase tracking-[0.15em] mb-3 ml-1">Full Name</label>
                        <input type="text" name="full_name" required value="{{ old('full_name', auth()->user()->name) }}" 
                               placeholder="Enter your name" 
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[12px] focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary/20 transition-all text-[14px] font-[700] text-navy">
                        @error('full_name') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] font-[900] text-navy uppercase tracking-[0.15em] mb-3 ml-1">Phone Number</label>
                        <input type="text" name="phone" required value="{{ old('phone') }}" 
                               placeholder="+91" 
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[12px] focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary/20 transition-all text-[14px] font-[700] text-navy">
                        @error('phone') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-[900] text-navy uppercase tracking-[0.15em] mb-3 ml-1">Email Address</label>
                        <input type="email" name="email" required value="{{ old('email', auth()->user()->email) }}" 
                               placeholder="your@email.com" 
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[12px] focus:ring-4 focus:ring-primary/5 focus:bg-white focus:border-primary/20 transition-all text-[14px] font-[700] text-navy">
                        @error('email') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-8">
                    <button type="submit" class="group w-full py-5 bg-primary text-white rounded-[12px] font-[900] text-[12px] uppercase tracking-[0.25em] hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20 active:scale-[0.98] flex items-center justify-center gap-3">
                        SUBMIT APPLICATION
                        <i class="bi bi-arrow-right-short text-xl group-hover:translate-x-1 transition-transform"></i>
                    </button>
                    <p class="text-center text-[10px] font-[800] text-muted/50 uppercase tracking-[0.2em] mt-8 flex items-center justify-center gap-2">
                        <i class="bi bi-safe-fill text-primary"></i> Encrypted with SSL Security
                    </p>
                </div>
                    <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-6 italic">
                        By submitting, you agree to our Terms of Service & Refund Policy
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
