<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() ?? '' }}">
    <title>@yield('title', 'OpacifyWeb — Remote Developers & Software Agency')</title>
    <meta name="description" content="@yield('meta_description', 'Hire experienced Laravel, React, Node.js, and full-stack developers. Premium software agency for hourly, dedicated, and project-based engagements.')">
    <link rel="canonical" href="@yield('canonical', 'https://opacifyweb.in')">
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,500&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Preview without Vite: uncomment Tailwind CDN + Alpine CDN below --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @stack('head')
</head>
<body class="has-mobile-fab bg-surface text-slate-600">
    @include('components.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('components.footer')

    <x-floating-actions />

    @stack('scripts')
</body>
</html>
