@extends('layouts.app')

@section('title', __('Page not found') . ' — ' . $settings->name)

@section('content')
<section class="relative isolate flex min-h-[70vh] flex-col items-center justify-center overflow-hidden px-5 pt-40 pb-24 text-center">
    {{-- Subtle blurred radial gradient blob, matching the hero section --}}
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        <div class="absolute -top-32 start-1/2 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full bg-brand-500/20 blur-3xl dark:bg-brand-600/20"></div>
        <div class="absolute end-0 top-40 h-72 w-72 rounded-full bg-accent-500/15 blur-3xl"></div>
    </div>

    <p class="font-display text-7xl font-extrabold leading-none tracking-tight sm:text-9xl bg-gradient-to-r from-brand-500 to-accent-500 bg-clip-text text-transparent">
        404
    </p>

    <p class="section-eyebrow mt-6">{{ __('Error') }}</p>

    <h1 class="mt-1 text-3xl font-bold sm:text-4xl">{{ __('Page not found') }}</h1>

    <p class="prose-body mt-4 max-w-md text-lg">
        {{ __("The page you're looking for doesn't exist or has been moved.") }}
    </p>

    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="btn-primary">{{ __('Go Home') }}</a>
        <a href="{{ route('projects.index') }}" class="btn-ghost">{{ __('View Projects') }}</a>
    </div>
</section>
@endsection
