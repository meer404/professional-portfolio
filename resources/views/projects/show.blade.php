@extends('layouts.app')

@section('title', $project->title . ' — ' . $settings->name)
@section('meta_description', $project->problem)

@section('content')
@php
    $features = $project->keyFeaturesList();
    $shots = $project->getMedia('screenshots');
@endphp

<article class="pt-28 pb-20 sm:pt-36">
    <div class="container-x max-w-3xl">
        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-brand-600 dark:text-slate-400">
            <svg class="h-4 w-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            {{ __('Back to projects') }}
        </a>

        <header class="mt-6">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $project->title }}</h1>
            <div class="mt-4 flex flex-wrap gap-1.5">
                @foreach ($project->tech_stack ?? [] as $tech)
                    <span class="badge">{{ $tech }}</span>
                @endforeach
            </div>
        </header>

        <div class="mt-12 space-y-12">
            {{-- 1. Problem --}}
            <section x-reveal>
                <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 dark:text-brand-400">{{ __('Problem') }}</h2>
                <p class="prose-body mt-3 text-lg">{{ $project->problem }}</p>
            </section>

            {{-- 2. What I Built --}}
            <section x-reveal>
                <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 dark:text-brand-400">{{ __('What I Built') }}</h2>
                <p class="prose-body mt-3 text-lg">{{ $project->what_i_built }}</p>
            </section>

            {{-- 3. Key Features --}}
            @if (count($features))
                <section x-reveal>
                    <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 dark:text-brand-400">{{ __('Key Features') }}</h2>
                    <ul class="mt-4 grid gap-2.5 sm:grid-cols-2">
                        @foreach ($features as $feature)
                            <li class="flex items-start gap-2.5">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                <span class="prose-body">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            {{-- 4. Tech Stack --}}
            <section x-reveal>
                <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 dark:text-brand-400">{{ __('Tech Stack') }}</h2>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($project->tech_stack ?? [] as $tech)
                        <span class="badge text-sm">{{ $tech }}</span>
                    @endforeach
                </div>
            </section>

            {{-- 5. My Role --}}
            @if ($project->my_role)
                <section x-reveal>
                    <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 dark:text-brand-400">{{ __('My Role') }}</h2>
                    <p class="prose-body mt-3 text-lg">{{ $project->my_role }}</p>
                </section>
            @endif

            {{-- 6. Live Demo + 8. GitHub --}}
            @if ($project->live_demo_url || ($project->github_url && $project->is_public_github))
                <section x-reveal class="flex flex-wrap gap-3">
                    @if ($project->live_demo_url)
                        <a href="{{ $project->live_demo_url }}" target="_blank" rel="noopener" class="btn-primary">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                            {{ __('Live Demo') }}
                        </a>
                    @endif
                    @if ($project->github_url && $project->is_public_github)
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn-ghost">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.58 2 12.26c0 4.5 2.87 8.32 6.84 9.67.5.1.68-.22.68-.48l-.01-1.7c-2.78.62-3.37-1.36-3.37-1.36-.45-1.18-1.11-1.5-1.11-1.5-.91-.64.07-.62.07-.62 1 .07 1.53 1.05 1.53 1.05.89 1.56 2.34 1.11 2.91.85.09-.66.35-1.11.63-1.36-2.22-.26-4.55-1.14-4.55-5.07 0-1.12.39-2.03 1.03-2.75-.1-.26-.45-1.3.1-2.7 0 0 .84-.28 2.75 1.05a9.3 9.3 0 0 1 5 0c1.91-1.33 2.75-1.05 2.75-1.05.55 1.4.2 2.44.1 2.7.64.72 1.03 1.63 1.03 2.75 0 3.94-2.34 4.8-4.57 5.06.36.32.68.95.68 1.92l-.01 2.85c0 .27.18.58.69.48A10.02 10.02 0 0 0 22 12.26C22 6.58 17.52 2 12 2Z" /></svg>
                            {{ __('View on GitHub') }}
                        </a>
                    @endif
                </section>
            @endif

            {{-- 7. Screenshots --}}
            @if ($shots->isNotEmpty())
                <section x-reveal x-data="{ open: false, active: 0, shots: {{ $shots->count() }} }" @keydown.escape.window="open = false">
                    <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 dark:text-brand-400">{{ __('Screenshots') }}</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        @foreach ($shots as $i => $shot)
                            <button type="button" @click="active = {{ $i }}; open = true"
                                    class="block w-full cursor-zoom-in text-start">
                                <x-window-frame :label="$project->title">
                                    <img src="{{ $shot->getUrl('web') }}" alt="{{ $shot->getCustomProperty('caption', '') }}" loading="lazy"
                                         class="h-full w-full object-cover">
                                </x-window-frame>
                            </button>
                        @endforeach
                    </div>

                    {{-- Lightbox --}}
                    <template x-teleport="body">
                        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 p-4"
                             x-transition.opacity @click.self="open = false">
                            <button @click="open = false" class="absolute end-4 top-4 grid h-10 w-10 place-items-center rounded-lg bg-white/10 text-white hover:bg-white/20" aria-label="Close">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                            </button>
                            <button x-show="shots > 1" @click="active = (active - 1 + shots) % shots" class="absolute start-4 grid h-11 w-11 place-items-center rounded-full bg-white/10 text-white hover:bg-white/20" aria-label="Previous">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                            </button>
                            <button x-show="shots > 1" @click="active = (active + 1) % shots" class="absolute end-4 grid h-11 w-11 place-items-center rounded-full bg-white/10 text-white hover:bg-white/20" aria-label="Next">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                            </button>
                            <div class="max-h-[85vh] max-w-none">
                                @foreach ($shots as $i => $shot)
                                    <figure x-show="active === {{ $i }}" class="flex flex-col items-center">
                                        <x-window-frame tone="dark" ratio="auto" :label="$project->title" class="mx-auto w-fit max-w-[85vw]">
                                            <img src="{{ $shot->getUrl('web') }}" alt="{{ $shot->getCustomProperty('caption', '') }}"
                                                 class="block max-h-[75vh] w-auto max-w-[85vw]">
                                        </x-window-frame>
                                        @if ($shot->getCustomProperty('caption'))
                                            <figcaption class="mt-3 text-center text-sm text-slate-300">{{ $shot->getCustomProperty('caption') }}</figcaption>
                                        @endif
                                    </figure>
                                @endforeach
                            </div>
                        </div>
                    </template>
                </section>
            @endif

            {{-- 9. Outcome --}}
            @if ($project->outcome)
                <section x-reveal class="rounded-2xl border border-brand-200 bg-brand-50/60 p-6 dark:border-brand-800/60 dark:bg-brand-950/30">
                    <h2 class="text-sm font-semibold uppercase tracking-widest text-brand-600 dark:text-brand-400">{{ __('Outcome') }}</h2>
                    <p class="mt-3 text-lg font-medium text-slate-800 dark:text-slate-100">{{ $project->outcome }}</p>
                </section>
            @endif
        </div>

        <div class="mt-16 border-t border-slate-200 pt-8 dark:border-slate-800">
            <a href="{{ route('home') }}#contact" class="btn-primary">{{ __("Let's build something") }}</a>
        </div>
    </div>
</article>
@endsection
