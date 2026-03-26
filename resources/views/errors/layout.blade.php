<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - EduLMS</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#F37021',
                        navy: '#1B365D',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .error-glow {
            text-shadow: 0 0 30px rgba(243, 112, 33, 0.2);
        }
        .bg-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#F3702110 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-pattern min-h-screen flex items-center justify-center p-6 text-slate-900 overflow-hidden">
    <div class="max-w-xl w-full text-center relative">
        <!-- Background Decoration -->
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-primary/10 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-navy/5 rounded-full blur-[80px]"></div>

        <div class="relative">
            <!-- Icon / Code -->
            <div class="mb-10 inline-flex items-center justify-center w-24 h-24 bg-white shadow-2xl rounded-[2rem] border border-slate-100 transform -rotate-12 hover:rotate-0 transition-transform duration-500">
                <i class="bi @yield('icon', 'bi-exclamation-triangle-fill') text-primary text-4xl"></i>
            </div>

            <!-- Error Code Area -->
            <h1 class="text-[120px] font-[900] leading-none tracking-tighter text-navy mb-4 error-glow">@yield('code')</h1>
            
            <!-- Message -->
            <h2 class="text-3xl font-[800] text-slate-900 mb-6 tracking-tight">@yield('title')</h2>
            <p class="text-slate-500 font-[500] text-lg mb-12 leading-relaxed">
                @yield('message')
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ url('/') }}" class="px-10 py-4 bg-navy text-white rounded-[16px] font-[800] text-[14px] uppercase tracking-[0.15em] hover:bg-slate-800 transition-all shadow-xl shadow-navy/20 flex items-center gap-3 active:scale-95">
                    <i class="bi bi-house-door-fill"></i> Back to Home
                </a>
                <button onclick="window.location.reload()" class="px-10 py-4 bg-white text-navy border border-border rounded-[16px] font-[800] text-[14px] uppercase tracking-[0.15em] hover:bg-slate-50 transition-all shadow-lg flex items-center gap-3 active:scale-95">
                    <i class="bi bi-arrow-clockwise"></i> Try Again
                </button>
            </div>
            
            <p class="mt-16 text-[11px] font-[800] text-slate-400 uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} THE ACE INDIA • EDU-LMS PLATFORM
            </p>
        </div>
    </div>
</body>
</html>
