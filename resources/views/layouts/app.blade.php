<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() ?? '' }}">
    <title>@yield('title', 'OpacifyWeb | Hire Skilled Remote Developers For Your Project')</title>
    <meta name="description" content="@yield('meta_description', 'Hire experienced Laravel, React, Node.js, and full-stack developers. A developer hiring platform for hourly, dedicated, and project-based engagements.')">
    <link rel="canonical" href="@yield('canonical', 'https://opacify.in')">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="icon" type="image/png" href="/images/favicon.png">

    {{-- Open Graph (falls back to the existing title/description/canonical sections) --}}
    <meta property="og:site_name" content="OpacifyWeb">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', View::yieldContent('title', 'OpacifyWeb | Hire Skilled Remote Developers For Your Project'))">
    <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', 'Hire experienced Laravel, React, Node.js, and full-stack developers.'))">
    <meta property="og:url" content="@yield('canonical', 'https://opacify.in')">
    <meta property="og:image" content="@yield('og_image', 'https://opacify.in/images/og-default.png')">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'Opacify - Custom Software Development Company')">
    <meta property="og:locale" content="en_US">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', View::yieldContent('title', 'OpacifyWeb'))">
    <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', 'Hire experienced Laravel, React, Node.js, and full-stack developers.'))">
    <meta name="twitter:image" content="@yield('og_image', 'https://opacify.in/images/og-default.png')">
    <meta name="twitter:image:alt" content="@yield('og_image_alt', 'Opacify - Custom Software Development Company')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,500&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Preview without Vite: uncomment Tailwind CDN + Alpine CDN below --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @include('components.schema-global')
    @stack('schema')
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