@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, \App\Http\Middleware\SetLocale::RTL, true);
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}" class="scroll-pt-24">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#6d28d9">

    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/mir-icon-purple.svg') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/mir-icon-white.svg') }}" media="(prefers-color-scheme: dark)">
    <link rel="mask-icon" href="{{ asset('brand/mir-icon-purple.svg') }}" color="#6d28d9">

    <title>@yield('title', $settings->name . ' — ' . ($settings->trans('hero_tagline') ?: __('Full-Stack Developer')))</title>
    <meta name="description" content="@yield('meta_description', strip_tags($settings->trans('about_me') ?? ''))">

    {{-- Social / Open Graph + Twitter Card --}}
    <meta property="og:title" content="@yield('og_title', $settings->name . ' — ' . ($settings->trans('hero_tagline') ?: __('Full-Stack Developer')))">
    <meta property="og:description" content="@yield('og_description', strip_tags($settings->trans('about_me') ?? ''))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $settings->name }}">
    <meta property="og:image" content="@yield('og_image', $settings->assetUrl($settings->profile_photo) ?? asset('brand/mir-icon-purple.svg'))">
    <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale() === 'ckb' ? 'ckb_IQ' : 'en_US') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', $settings->name . ' — ' . ($settings->trans('hero_tagline') ?: __('Full-Stack Developer')))">
    <meta name="twitter:description" content="@yield('og_description', strip_tags($settings->trans('about_me') ?? ''))">
    <meta name="twitter:image" content="@yield('og_image', $settings->assetUrl($settings->profile_photo) ?? asset('brand/mir-icon-purple.svg'))">

    {{-- Resolve theme before first paint to avoid a flash --}}
    <script>
        (function () {
            try {
                var stored = localStorage.getItem('theme');
                var dark = stored ? stored === 'dark'
                    : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@500;600;700;800&family=Noto+Kufi+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:m-3 focus:rounded-lg focus:bg-brand-600 focus:px-4 focus:py-2 focus:text-white">
        {{ __('Skip to content') }}
    </a>

    @include('partials.nav')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
