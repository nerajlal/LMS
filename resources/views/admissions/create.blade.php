@extends('layouts.app')

@section('title', 'Course Enrollment - The Ace India')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl overflow-hidden flex flex-col md:flex-row">
        <!-- Sidebar Branding -->
        <div class="w-full md:w-72 bg-slate-900 p-10 text-white relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#e3000f]/20 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="w-12 h-12 bg-[#e3000f] rounded-2xl flex items-center justify-center text-white text-2xl font-black mb-10 shadow-lg">A</div>
                <h2 class="text-2xl font-black tracking-tight leading-tight mb-6">Complete Your <br><span class="text-[#e3000f]">Admission</span></h2>
                <div class="space-y-6 mt-auto">
                    <div class="flex items-center gap-3 text-xs font-bold text-slate-400 tracking-wider">
                        <i class="bi bi-shield-lock-fill text-[#e3000f]"></i> SECURE ENROLLMENT
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Area -->
        <div class="flex-1 p-10 lg:p-14 relative">
            <div class="absolute top-0 right-0 p-8">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-[#e3000f] animate-pulse"></div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Step 1 of 2</span>
                </div>
            </div>

            <form action="{{ route('admissions.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Course Assignment</label>
                        <select name="course_id" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold appearance-none cursor-pointer">
                            <option value="">-- Choose Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Full Name</label>
                        <input type="text" name="full_name" required value="{{ old('full_name', Auth::user()->name) }}" 
                               placeholder="As per documents" 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold">
                        @error('full_name') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Contact Phone</label>
                        <input type="text" name="phone" required value="{{ old('phone') }}" 
                               placeholder="+91 0000 0000 00" 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold">
                        @error('phone') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 pl-1">Email Address</label>
                        <input type="email" name="email" required value="{{ old('email', Auth::user()->email) }}" 
                               placeholder="name@example.com" 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#e3000f]/20 focus:bg-white transition-all text-sm font-bold">
                        @error('email') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full py-5 bg-[#e3000f] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#cc0000] transition-all transform hover:-translate-y-1 shadow-xl shadow-red-500/20 active:scale-95">
                        Submit Application & Proceed
                    </button>
                    <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-6 italic">
                        By submitting, you agree to our Terms of Service & Refund Policy
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
