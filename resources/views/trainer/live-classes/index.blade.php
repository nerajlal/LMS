@extends('layouts.admin')

@section('title', 'Live Classes')

@section('content')
<div class="space-y-8">
<div class="space-y-8">
    <!-- Cinematic Header -->
    <div class="relative overflow-hidden rounded-[16px] bg-navy p-6 md:p-8 text-white shadow-xl">
        <div class="absolute top-[-20px] right-[-20px] w-[200px] h-[200px] bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[14px] bg-white/5 border border-white/10 flex items-center justify-center backdrop-blur-md shadow-lg">
                    <i class="bi bi-camera-video text-primary text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-[900] tracking-tight text-white uppercase">Live Class <span class="text-primary">Batches</span></h1>
                    <p class="text-slate-400 text-[10px] md:text-[12px] font-[600] uppercase tracking-widest mt-0.5">Organize and schedule your sessions by batch</p>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Status Toggle -->
                <div class="flex items-center gap-1 bg-white/5 border border-white/10 p-1.5 rounded-[12px] backdrop-blur-md">
                    <a href="{{ route('trainer.live-classes.index', ['status' => 'active']) }}" 
                       class="px-4 py-2 rounded-[8px] text-[10px] font-[900] uppercase tracking-widest transition-all {{ ($currentStatus ?? 'active') === 'active' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:text-white' }}">
                        Ongoing
                    </a>
                    <a href="{{ route('trainer.live-classes.index', ['status' => 'completed']) }}" 
                       class="px-4 py-2 rounded-[8px] text-[10px] font-[900] uppercase tracking-widest transition-all {{ ($currentStatus ?? 'active') === 'completed' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-400 hover:text-white' }}">
                        Completed
                    </a>
                </div>

                <button onclick="document.getElementById('branchModal').showModal()" class="px-6 py-3.5 bg-primary text-white font-[900] text-[12px] rounded-[12px] hover:bg-orange-600 transition-all flex items-center gap-3 uppercase tracking-widest shadow-xl shadow-orange-500/20">
                    <i class="bi bi-plus-lg text-lg"></i>
                    <span>New Batch</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Branch Sections -->
    <div class="space-y-8">
        @foreach($branches as $branch)
        <div class="bg-white rounded-[20px] border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-border flex justify-between items-center" x-data="{ open: false }">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-[10px] bg-navy text-white flex items-center justify-center">
                        <i class="bi bi-folder2-open"></i>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-[900] text-navy uppercase tracking-tight">{{ $branch->name }}</h3>
                        <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest">{{ $branch->course->title ?? 'General Batch' }}</p>
                        @if($branch->trainers->where('id', '!=', auth()->id())->count() > 0)
                            <div class="mt-1 flex items-center gap-1.5 opacity-60">
                                <i class="bi bi-people-fill text-[10px] text-primary"></i>
                                <span class="text-[9px] font-[800] text-slate-400 uppercase tracking-widest">Collaborators: {{ $branch->trainers->where('id', '!=', auth()->id())->pluck('name')->join(', ') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-[10px] font-[800] text-slate-400 uppercase tracking-widest bg-white border border-border px-3 py-1.5 rounded-full">
                        {{ $branch->liveClasses->count() }} Sessions
                    </div>
                    
                    <button onclick="viewBatchSummary({{ $branch->id }}, '{{ addslashes($branch->name) }}')" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-[900] uppercase tracking-widest rounded-full hover:bg-emerald-600 hover:text-white transition-all shadow-sm flex items-center gap-2">
                        <i class="bi bi-graph-up-arrow"></i> Overall Stats
                    </button>

                    @if(($currentStatus ?? 'active') === 'active')
                        <a href="{{ route('trainer.live-classes.create', ['branch_id' => $branch->id]) }}" class="px-4 py-2 bg-primary text-white text-[10px] font-[900] uppercase tracking-widest rounded-[8px] hover:bg-orange-600 transition-all shadow-sm">
                            <i class="bi bi-plus-lg"></i> Add Session
                        </a>
                        
                        <form action="{{ route('trainer.live-classes.branches.complete', $branch->id) }}" method="POST" onsubmit="return confirm('Archive this batch? No further sessions can be added once completed.')">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-navy text-white text-[10px] font-[900] uppercase tracking-widest rounded-[8px] hover:bg-slate-800 transition-all shadow-sm">
                                <i class="bi bi-check-all text-[14px]"></i> Complete
                            </button>
                        </form>
                    @else
                        <div class="px-4 py-2 bg-slate-100 text-slate-400 text-[10px] font-[900] uppercase tracking-widest rounded-[8px] flex items-center gap-2">
                            <i class="bi bi-archive-fill"></i> Archived
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-border">
                        @forelse($branch->liveClasses as $class)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="text-[14px] font-[800] text-navy group-hover:text-primary transition-colors leading-tight truncate max-w-[200px]">{{ $class->title }}</div>
                                <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1.5 flex items-center gap-2">
                                    <i class="bi bi-clock text-primary"></i> {{ \Carbon\Carbon::parse($class->start_time)->format('M d, g:i A') }} ({{ $class->duration }})
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <div @class([
                                        'flex items-center gap-2 text-[10px] font-[900] uppercase tracking-widest mr-4',
                                        'text-emerald-600' => $class->isLive(),
                                        'text-slate-400' => $class->isEnded(),
                                        'text-amber-500' => !$class->isLive() && !$class->isEnded(),
                                    ])>
                                        {{ $class->isLive() ? 'Live Now' : ($class->isEnded() ? 'Ended' : 'Upcoming') }}
                                    </div>
                                    @if($class->isEnded())
                                        @if($class->recording_url)
                                            <a href="{{ $class->recording_url }}" target="_blank" class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-[10px] text-[11px] font-[800] uppercase tracking-widest border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-all">
                                                Watch <i class="bi bi-play-circle"></i>
                                            </a>
                                            <button onclick="openRecordingModal({{ $class->id }}, '{{ $class->recording_url }}', '{{ $class->recording_description }}')" class="p-2 text-slate-400 hover:text-navy transition-colors">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        @else
                                            <button onclick="openRecordingModal({{ $class->id }})" class="px-4 py-2 bg-primary/10 text-primary rounded-[10px] text-[11px] font-[800] uppercase tracking-widest border border-primary/20 hover:bg-primary hover:text-white transition-all">
                                                Add Recording <i class="bi bi-plus-lg"></i>
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ $class->zoom_link }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-navy rounded-[10px] text-[11px] font-[800] uppercase tracking-widest hover:bg-navy hover:text-white transition-all border border-slate-200">
                                            Join <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    @endif

                                    <button onclick="viewAttendance({{ $class->id }}, '{{ addslashes($class->title) }}')" class="w-10 h-10 rounded-[10px] bg-navy/5 text-navy flex items-center justify-center hover:bg-navy hover:text-white transition-all border border-navy/10" title="View Attendance">
                                        <i class="bi bi-people"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center bg-slate-50/20">
                                <p class="text-[12px] text-slate-400 italic font-[600]">No sessions yet in this batch.</p>
                                <a href="{{ route('trainer.live-classes.create', ['branch_id' => $branch->id]) }}" class="mt-3 inline-flex items-center gap-2 text-primary font-[800] text-[11px] uppercase tracking-widest hover:underline">
                                    <i class="bi bi-plus-circle"></i> Create first session
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach

        <!-- Unbranched Classes (Legacy/General) -->
        @if($unbranchedClasses->count() > 0)
        <div class="bg-white rounded-[20px] border border-border shadow-sm overflow-hidden border-dashed border-2">
            <div class="px-6 py-4 bg-slate-50/30 border-b border-border flex justify-between items-center">
                <div class="flex items-center gap-3 opacity-60">
                    <div class="w-10 h-10 rounded-[10px] bg-slate-200 text-slate-500 flex items-center justify-center border border-slate-300">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-[900] text-slate-500 uppercase tracking-tight">Unorganized Sessions</h3>
                        <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest">Legacy or general live classes</p>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-border">
                        @foreach($unbranchedClasses as $class)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="text-[14px] font-[800] text-slate-500 group-hover:text-primary transition-colors leading-tight truncate max-w-[200px]">{{ $class->title }}</div>
                                <div class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest mt-1.5 flex items-center gap-2">
                                    <i class="bi bi-clock text-slate-300"></i> {{ \Carbon\Carbon::parse($class->start_time)->format('M d, g:i A') }}
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                @if($class->isEnded())
                                    <div class="px-4 py-2 bg-slate-50 text-slate-300 rounded-[10px] text-[11px] font-[800] uppercase tracking-widest border border-slate-100 italic">
                                        Ended
                                    </div>
                                @else
                                    <a href="{{ $class->zoom_link }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-400 rounded-[10px] text-[11px] font-[800] uppercase tracking-widest hover:bg-navy hover:text-white transition-all border border-slate-200">
                                        Join <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($branches->isEmpty() && $unbranchedClasses->isEmpty())
        <div class="bg-white rounded-[20px] border-2 border-dashed border-border p-20 text-center">
            <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mx-auto mb-6">
                <i class="bi bi-collection-play text-4xl"></i>
            </div>
            <h3 class="text-xl font-[900] text-navy uppercase tracking-tight mb-2">Build your first batch</h3>
            <p class="text-slate-500 text-[14px] max-w-sm mx-auto mb-10">Create a batch to group your live sessions. It helps you and your students stay organized.</p>
            <button onclick="document.getElementById('branchModal').showModal()" class="px-8 py-4 bg-navy text-white font-[900] text-[13px] rounded-[16px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20">
                Create Your First Batch
            </button>
        </div>
        @endif
    </div>

    <!-- Create Branch Modal -->
    <dialog id="branchModal" class="p-0 rounded-[24px] shadow-2xl border-none backdrop:backdrop-blur-sm">
        <div class="w-[450px] bg-white">
            <div class="p-8 border-b border-border bg-slate-50/50">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Create New <span class="text-primary">Batch</span></h3>
                    <button onclick="document.getElementById('branchModal').close()" class="text-slate-400 hover:text-navy transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest">Group your live classes for a specific cohort</p>
            </div>
            
            <form action="{{ route('trainer.live-classes.branches.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Batch Name</label>
                    <input type="text" name="name" required placeholder="e.g. Batch A - Morning" 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy placeholder:text-slate-300 italic">
                </div>
                
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Select Academic Blueprint</label>
                    <div class="relative">
                        <select name="course_id" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[15px] font-[700] text-navy appearance-none cursor-pointer">
                            <option value="" disabled selected>Choose a Course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-navy/30 pointer-events-none"></i>
                    </div>
                    <p class="mt-2.5 px-1 text-[9px] text-slate-400 font-[700] uppercase tracking-widest leading-relaxed">
                        <i class="bi bi-info-circle text-primary"></i> The batch will inherit all recorded curriculum from this course blueprint.
                    </p>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-navy text-white rounded-[14px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20 active:scale-[0.98]">
                        Create Batch
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Commented out: moved to Admin --}}
    {{-- 
    <!-- Coupon Modal -->
    <dialog id="couponModal" class="p-0 rounded-[24px] shadow-2xl border-none backdrop:backdrop-blur-sm"
            ...
    </dialog>
    --}}

    <!-- Recording Modal -->
    <dialog id="recordingModal" class="p-0 rounded-[24px] shadow-2xl border-none backdrop:backdrop-blur-sm">
        <div class="w-[500px] bg-white">
            <div class="p-8 border-b border-border bg-slate-50/50">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Add Session <span class="text-primary">Recording</span></h3>
                    <button onclick="document.getElementById('recordingModal').close()" class="text-slate-400 hover:text-navy transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest">Provide the URL for the recorded session (e.g. YouTube/Drive)</p>
            </div>
            
            <form id="recordingForm" action="" method="POST" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Recording URL</label>
                    <input type="url" name="recording_url" id="rec_url" required placeholder="https://youtube.com/watch?v=..." 
                           class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy placeholder:text-slate-300">
                </div>
                
                <div>
                    <label class="block text-[11px] font-[900] text-navy/50 uppercase tracking-[0.2em] mb-2.5 px-1">Brief Description (Optional)</label>
                    <textarea name="recording_description" id="rec_desc" rows="3" placeholder="Summary of what was covered..." 
                              class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[14px] focus:border-primary/20 focus:bg-white focus:ring-0 transition-all text-[14px] font-[600] text-navy placeholder:text-slate-300 resize-none"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-navy text-white rounded-[14px] font-[900] text-[13px] uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-navy/20 active:scale-[0.98]">
                        Save Recording
                    </button>
                    <p class="text-center mt-4 text-[10px] text-slate-400 font-[600] uppercase tracking-widest">Students in this batch will see this instantly.</p>
                </div>
            </form>
        </div>
    </dialog>
    
    <!-- Attendance Modal -->
    <dialog id="attendanceModal" class="p-0 rounded-[28px] shadow-2xl border-none backdrop:backdrop-blur-md">
        <div class="w-[600px] bg-white min-h-[400px] flex flex-col">
            <div class="p-8 border-b border-border bg-slate-50/50">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Attendance <span class="text-primary">Protocol</span></h3>
                    <button onclick="document.getElementById('attendanceModal').close()" class="text-slate-400 hover:text-navy transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest" id="attendanceClassTitle">Session Participation Log</p>
            </div>
            
            <div class="flex-1 p-0 overflow-y-auto max-h-[500px]" id="attendanceContent">
                <div class="p-20 text-center text-slate-400">
                    <div class="inline-block animate-spin mb-4"><i class="bi bi-arrow-repeat text-2xl"></i></div>
                    <p class="text-[12px] font-[600] uppercase tracking-widest">Fetching logs...</p>
                </div>
            </div>

            <div class="p-6 border-t border-border bg-slate-50/50 text-center">
                <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest">
                    <i class="bi bi-info-circle text-primary mr-1"></i> Logs are recorded only when students click 'Join Now' on their dashboard.
                </p>
            </div>
        </div>
    </dialog>
</div>

    <!-- Batch Attendance Summary Modal -->
    <dialog id="batchAttendanceModal" class="p-0 rounded-[28px] shadow-2xl border-none backdrop:backdrop-blur-md">
        <div class="w-[800px] bg-white min-h-[500px] flex flex-col">
            <div class="p-8 border-b border-border bg-slate-50/50">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-xl font-[900] text-navy uppercase tracking-tight">Batch Attendance <span class="text-primary">Master Report</span></h3>
                    <button onclick="document.getElementById('batchAttendanceModal').close()" class="text-slate-400 hover:text-navy transition-colors">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 font-[700] uppercase tracking-widest" id="summaryBatchName">Overall Participation Summary</p>
            </div>
            
            <div class="flex-1 p-0 overflow-y-auto max-h-[600px]" id="summaryContent">
                <div class="p-20 text-center text-slate-400">
                    <div class="inline-block animate-spin mb-4"><i class="bi bi-arrow-repeat text-2xl"></i></div>
                    <p class="text-[12px] font-[600] uppercase tracking-widest">Aggregating session data...</p>
                </div>
            </div>

            <div class="p-6 border-t border-border bg-slate-100/50 flex justify-between items-center">
                <p class="text-[10px] text-slate-400 font-[700] uppercase tracking-widest">
                    <i class="bi bi-info-circle text-primary mr-1"></i> Based on all Live or Completed sessions in this batch.
                </p>
                <div id="summaryTotalSessions" class="text-[10px] font-[900] text-navy uppercase tracking-widest bg-white px-3 py-1.5 rounded-full border border-border mt-0"></div>
            </div>
        </div>
    </dialog>
</div>

<script>
    function openRecordingModal(classId, existingUrl = '', existingDesc = '') {
        const modal = document.getElementById('recordingModal');
        const form = document.getElementById('recordingForm');
        const urlInput = document.getElementById('rec_url');
        const descInput = document.getElementById('rec_desc');
        
        form.action = `/trainer/live-classes/${classId}/recording`;
        urlInput.value = existingUrl;
        descInput.value = existingDesc;
        
        modal.showModal();
    }

    function viewAttendance(classId, classTitle) {
        const modal = document.getElementById('attendanceModal');
        const content = document.getElementById('attendanceContent');
        const titleText = document.getElementById('attendanceClassTitle');
        
        titleText.innerText = classTitle;
        content.innerHTML = `
            <div class="p-20 text-center text-slate-400">
                <div class="inline-block animate-spin mb-4"><i class="bi bi-arrow-repeat text-2xl"></i></div>
                <p class="text-[12px] font-[600] uppercase tracking-widest">Analyzing participation data...</p>
            </div>
        `;
        
        modal.showModal();
        
        fetch(`/live-classes/${classId}/attendance`)
            .then(response => {
                if (response.status === 403) throw new Error('Unauthorized Access Protocol');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (data.attendances.length === 0) {
                        content.innerHTML = `
                            <div class="p-20 text-center">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mx-auto mb-4">
                                    <i class="bi bi-person-x text-2xl"></i>
                                </div>
                                <h4 class="text-navy font-[800] uppercase tracking-tight">No Participants Yet</h4>
                                <p class="text-[12px] text-slate-400 font-[500] mt-1">Attendance logs will appear here once students join.</p>
                            </div>
                        `;
                        return;
                    }

                    let tableHtml = `
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-border">
                                <tr>
                                    <th class="px-8 py-4 text-[10px] font-[900] text-navy uppercase tracking-widest">Student</th>
                                    <th class="px-8 py-4 text-[10px] font-[900] text-navy uppercase tracking-widest">Joined At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                    `;

                    data.attendances.forEach(att => {
                        const date = new Date(att.joined_at);
                        const timeStr = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        const dateStr = date.toLocaleDateString([], { month: 'short', day: 'numeric' });
                        
                        // Safe-render student info
                        const studentName = att.user ? att.user.name : 'Unknown Student';
                        const studentEmail = att.user ? att.user.email : 'Deleted User';
                        
                        tableHtml += `
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="text-[14px] font-[800] text-navy">${studentName}</div>
                                    <div class="text-[10px] text-slate-400 font-[600] uppercase tracking-widest">${studentEmail}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-[13px] font-[700] text-navy">${timeStr}</div>
                                    <div class="text-[10px] text-slate-400 font-[600] uppercase tracking-widest">${dateStr}</div>
                                </td>
                            </tr>
                        `;
                    });

                    tableHtml += `</tbody></table>`;
                    content.innerHTML = tableHtml;
                } else {
                    content.innerHTML = `<p class="p-8 text-rose-500 font-[600] text-center">Failed to load logs.</p>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const msg = error.message === 'Unauthorized Access Protocol' ? 'Unauthorized Access Protocol' : 'Network error while fetching logs.';
                content.innerHTML = `<p class="p-8 text-rose-500 font-[600] text-center uppercase tracking-widest text-[11px]">${msg}</p>`;
            });
    }

    function viewBatchSummary(branchId, branchName) {
        const modal = document.getElementById('batchAttendanceModal');
        const content = document.getElementById('summaryContent');
        const titleText = document.getElementById('summaryBatchName');
        const sessionBadge = document.getElementById('summaryTotalSessions');
        
        titleText.innerText = branchName;
        content.innerHTML = `
            <div class="p-20 text-center text-slate-400">
                <div class="inline-block animate-spin mb-4"><i class="bi bi-arrow-repeat text-2xl"></i></div>
                <p class="text-[12px] font-[600] uppercase tracking-widest">Compiling overall participation matrix...</p>
            </div>
        `;
        sessionBadge.innerText = '';
        
        modal.showModal();
        
        fetch(`/live-classes/batches/${branchId}/attendance-summary`)
            .then(response => {
                if (response.status === 403) throw new Error('Unauthorized Summary Request');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    sessionBadge.innerText = `${data.total_sessions} Total Sessions Held`;
                    
                    if (data.summary.length === 0) {
                        content.innerHTML = `
                            <div class="p-20 text-center">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mx-auto mb-4">
                                    <i class="bi bi-people-fill text-2xl"></i>
                                </div>
                                <h4 class="text-navy font-[800] uppercase tracking-tight">No Enrolled Students</h4>
                                <p class="text-[12px] text-slate-400 font-[500] mt-1">No student admissions found for this batch.</p>
                            </div>
                        `;
                        return;
                    }

                    let tableHtml = `
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 border-b border-border sticky top-0 z-10 shadow-sm">
                                <tr>
                                    <th class="px-8 py-4 text-[10px] font-[900] text-navy uppercase tracking-widest">Student Details</th>
                                    <th class="px-8 py-4 text-[10px] font-[900] text-navy uppercase tracking-widest text-center">Engagement</th>
                                    <th class="px-8 py-4 text-[10px] font-[900] text-navy uppercase tracking-widest text-right">Attendance %</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                    `;

                    data.summary.forEach(item => {
                        const progressColor = item.percentage >= 80 ? 'emerald' : (item.percentage >= 50 ? 'amber' : 'rose');
                        
                        tableHtml += `
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="text-[14px] font-[800] text-navy">${item.student_name}</div>
                                    <div class="text-[10px] text-slate-400 font-[600] uppercase tracking-widest">${item.student_email}</div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="inline-flex items-center gap-2 bg-slate-50 px-3 py-1.5 rounded-full border border-border">
                                        <span class="text-[13px] font-[900] text-navy">${item.attended}</span>
                                        <span class="text-[10px] text-slate-400 font-[700]">/ ${item.total}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex flex-col items-end gap-1.5 text-right">
                                        <div class="text-[15px] font-[900] text-${progressColor}-600 tracking-tighter">${item.percentage}%</div>
                                        <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-${progressColor}-500 rounded-full" style="width: ${item.percentage}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    tableHtml += `</tbody></table>`;
                    content.innerHTML = tableHtml;
                } else {
                    content.innerHTML = `<p class="p-8 text-rose-500 font-[600] text-center">Failed to generate summary report.</p>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const msg = error.message === 'Unauthorized Summary Request' ? 'Unauthorized Summary Request' : 'Network error while generating report.';
                content.innerHTML = `<p class="p-8 text-rose-500 font-[600] text-center uppercase tracking-widest text-[11px]">${msg}</p>`;
            });
    }
</script>
@endsection
