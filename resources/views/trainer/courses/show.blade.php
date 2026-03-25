@extends('layouts.admin')

@section('title', 'Manage: ' . $course->title)

@section('content')
<div x-data="{ activeTab: 'lessons' }" class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="text-[10px] font-black text-[#F37021] uppercase tracking-[0.2em] mb-2">Course Management</div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $course->title }}</h1>
        </div>
        <div class="flex bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm self-start md:self-center">
            <button @click="activeTab = 'lessons'" 
                    :class="activeTab === 'lessons' ? 'bg-[#F37021] text-white shadow-lg shadow-orange-500/20' : 'text-slate-500 hover:text-slate-900'"
                    class="px-6 py-2.5 rounded-xl font-bold tracking-tight transition-all flex items-center gap-2 text-sm">
                <i class="bi bi-play-circle"></i> Lessons
            </button>
            <button @click="activeTab = 'materials'" 
                    :class="activeTab === 'materials' ? 'bg-[#F37021] text-white shadow-lg shadow-orange-500/20' : 'text-slate-500 hover:text-slate-900'"
                    class="px-6 py-2.5 rounded-xl font-bold tracking-tight transition-all flex items-center gap-2 text-sm">
                <i class="bi bi-file-earmark-pdf"></i> Materials
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl text-sm font-bold animate-slide-up">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- List Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Lessons List -->
            <div x-show="activeTab === 'lessons'" x-transition class="space-y-4">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Recorded Video Lessons</h3>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ count($course->lessons) }} Total</span>
                </div>
                <div class="grid gap-3">
                    @forelse($course->lessons as $index => $lesson)
                    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-red-50 text-[#F37021] flex items-center justify-center font-black text-sm shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-slate-900 truncate leading-none mb-1.5">{{ $lesson->title }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest truncate">{{ $lesson->video_url }}</div>
                        </div>
                        <div class="p-2 text-slate-300 group-hover:text-[#F37021] transition-colors">
                            <i class="bi bi-play-circle-fill text-2xl"></i>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white py-16 rounded-[2.5rem] border border-slate-100 shadow-sm text-center">
                        <div class="w-12 h-12 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
                            <i class="bi bi-camera-video"></i>
                        </div>
                        <p class="text-slate-400 font-bold text-sm">No video lessons recorded yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Materials List -->
            <div x-show="activeTab === 'materials'" x-transition x-cloak class="space-y-4">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">PDF Study Materials</h3>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ count($course->studyMaterials) }} Files</span>
                </div>
                <div class="grid gap-3">
                    @forelse($course->studyMaterials as $mat)
                    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl shrink-0">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-slate-900 truncate leading-none mb-1.5">{{ $mat->title }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                {{ strtoupper($mat->file_type) }} &bull; {{ number_format($mat->file_size / (1024 * 1024), 2) }} MB
                            </div>
                        </div>
                        <a href="{{ $mat->file_path }}" target="_blank" class="p-2.5 rounded-xl bg-slate-50 text-slate-500 hover:bg-[#F37021] hover:text-white transition-all">
                            <i class="bi bi-download text-lg"></i>
                        </a>
                    </div>
                    @empty
                    <div class="bg-white py-16 rounded-[2.5rem] border border-slate-100 shadow-sm text-center">
                        <div class="w-12 h-12 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 text-xl">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <p class="text-slate-400 font-bold text-sm">No materials uploaded yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Form Sidebar -->
        <div class="space-y-8">
            <!-- Add Lesson Form -->
            <div x-show="activeTab === 'lessons'" x-transition class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-6 sticky top-24 transition-all hover:shadow-lg">
                <h3 class="text-sm font-black text-[#F37021] uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Append New Lesson
                </h3>
                <form action="{{ route('trainer.courses.lessons.store', $course->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 pl-1">Lesson Title</label>
                        <input type="text" name="title" required placeholder="e.g. Master the Foundations" 
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#F37021]/20 focus:bg-white transition-all text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 pl-1">YouTube Embed URL</label>
                        <input type="url" name="video_url" required placeholder="https://youtube.com/embed/..." 
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#F37021]/20 focus:bg-white transition-all text-sm font-bold">
                    </div>
                    <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#F37021] transition-all shadow-xl shadow-slate-900/10">
                        Add to Lesson List
                    </button>
                </form>
            </div>

            <!-- Add Material Form -->
            <div x-show="activeTab === 'materials'" x-transition x-cloak class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-6 sticky top-24 transition-all hover:shadow-lg">
                <h3 class="text-sm font-black text-orange-600 uppercase tracking-widest flex items-center gap-2">
                    <i class="bi bi-cloud-arrow-up"></i> Upload Document
                </h3>
                <form action="{{ route('trainer.courses.materials.store', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 pl-1">Material Name</label>
                        <input type="text" name="title" required placeholder="e.g. week_1_handout.pdf" 
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-orange-500/20 focus:bg-white transition-all text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 pl-1">File (PDF/DOC/ZIP)</label>
                        <div class="relative group">
                            <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="px-4 py-8 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl text-center group-hover:border-orange-200 transition-colors">
                                <i class="bi bi-file-earmark-plus text-2xl text-slate-300"></i>
                                <div class="text-xs font-bold text-slate-400 mt-2">Click or Drop File Here</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-orange-600 transition-all shadow-xl shadow-slate-900/10">
                        Start Secure Upload
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
