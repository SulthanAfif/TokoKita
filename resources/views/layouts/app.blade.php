<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'TokoKita') — Belanja Online Terpercaya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        html { -webkit-text-size-adjust: 100%; scroll-behavior: smooth; }
        body { overflow-x: hidden; }
        img, video, canvas, svg { max-width: 100%; height: auto; }
        /* Safe area (iPhone notch) */
        .safe-pb { padding-bottom: env(safe-area-inset-bottom, 0); }
        .safe-pt { padding-top: env(safe-area-inset-top, 0); }
        /* Touch targets */
        @media (pointer: coarse) {
            button, a, [role="button"] { min-height: 40px; }
        }
        /* Smooth table scroll on mobile */
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        /* Hide scrollbar utility */
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
    <meta name="theme-color" content="#4f46e5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <x-navbar />

    {{-- Flash messages --}}
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mt-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm flex items-center gap-2"
                 x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mt-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mt-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main class="flex-1 max-w-7xl mx-auto w-full px-3 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        @yield('content')
    </main>

    <x-footer />

</body>
</html>
