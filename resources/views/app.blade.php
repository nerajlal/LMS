<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title inertia>{{ config('app.name', 'EduLMS') }}</title>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            *, *::before, *::after { box-sizing: border-box; }
            body {
                font-family: 'Inter', sans-serif;
                margin: 0;
                background: #f3f4f6;
                color: #1f2937;
                -webkit-font-smoothing: antialiased;
            }
            a { color: #e3000f; }
            input::placeholder, textarea::placeholder { color: #9ca3af !important; }
            /* Sidebar nav link hover */
            nav a:hover {
                background: #fff1f2 !important;
                color: #e3000f !important;
            }
            /* Smooth animations */
            * { transition-duration: 0.15s; }
            /* Custom scrollbar */
            ::-webkit-scrollbar { width: 5px; }
            ::-webkit-scrollbar-track { background: #f3f4f6; }
            ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
            ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
            /* Live pulse */
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }
        </style>

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
    </head>
    <body>
        @inertia

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
