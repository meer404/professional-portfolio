@extends('layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $phrases = $settings->hero_phrases[$locale] ?? $settings->hero_phrases['en'] ?? [];
    $photo = $settings->assetUrl($settings->profile_photo);
    $cvEn = $settings->assetUrl($settings->cv_en);
    $cvCkb = $settings->assetUrl($settings->cv_ckb);
    $primaryCv = $locale === 'ckb' ? ($cvCkb ?? $cvEn) : ($cvEn ?? $cvCkb);
@endphp

{{-- ============================ HERO ============================ --}}
<section class="relative overflow-hidden pt-28 pb-16 sm:pt-36 sm:pb-24">
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -top-32 start-1/2 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full bg-brand-500/20 blur-3xl dark:bg-brand-600/20"></div>
        <div class="absolute end-0 top-40 h-72 w-72 rounded-full bg-accent-500/15 blur-3xl"></div>
    </div>

    <div class="container-x grid items-center gap-12 lg:grid-cols-[1.15fr_0.85fr]">
        <div>
            <p class="section-eyebrow">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                </span>
                {{ __('Available for work') }}
            </p>

            <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                {{ $settings->name }}
            </h1>

            <p class="mt-4 h-8 font-display text-xl font-semibold text-brand-600 sm:text-2xl dark:text-brand-400"
               x-data="typewriter(@js($phrases))" x-init="start()">
                <span x-text="text"></span><span class="ms-0.5 inline-block w-0.5 animate-pulse bg-current align-middle" style="height:1em"></span>
            </p>

            <p class="prose-body mt-5 max-w-xl text-lg">
                {{ $settings->trans('hero_tagline') }}
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                @if ($primaryCv)
                    <a href="{{ $primaryCv }}" target="_blank" rel="noopener" class="btn-primary">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        {{ __('Download CV') }}
                    </a>
                @endif
                <a href="{{ route('projects.index') }}" class="btn-ghost">
                    {{ __('View Projects') }}
                    <svg class="h-4 w-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>

            <div class="mt-8 flex items-center gap-4 text-sm text-slate-500 dark:text-slate-400">
                <span>{{ __('Based in') }} {{ $settings->trans('location') }}</span>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-xs lg:max-w-sm" x-reveal>
            <div class="absolute inset-0 -z-10 rounded-[2rem] bg-linear-to-br from-brand-500 to-accent-500 opacity-30 blur-2xl"></div>
            <div class="rounded-[2rem] bg-linear-to-br from-brand-500 via-brand-400 to-accent-500 p-1">
                <div class="overflow-hidden rounded-[1.85rem] bg-white dark:bg-slate-900">
                    @if ($photo)
                        <img src="{{ $photo }}" alt="{{ $settings->name }}" class="aspect-4/5 w-full object-cover" width="480" height="600">
                    @else
                        <div class="grid aspect-4/5 w-full place-items-center bg-linear-to-br from-brand-100 to-accent-100 p-12 dark:from-slate-800 dark:to-slate-800">
                            <img src="{{ asset('brand/mir-icon-purple.svg') }}" alt="{{ $settings->name }}" class="w-full opacity-80 dark:hidden">
                            <img src="{{ asset('brand/mir-icon-white.svg') }}" alt="{{ $settings->name }}" class="hidden w-full opacity-90 dark:block">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================ ABOUT ============================ --}}
<section id="about" class="scroll-mt-24 border-t border-slate-100 py-20 dark:border-slate-900">
    <div class="container-x grid gap-10 lg:grid-cols-[0.4fr_0.6fr]" x-reveal>
        <div>
            <p class="section-eyebrow">{{ __('About') }}</p>
            <h2 class="mt-2 text-3xl font-bold sm:text-4xl">{{ __('About Me') }}</h2>
        </div>
        <div class="prose-body space-y-4 text-lg [&_a]:text-brand-600 [&_a]:underline">
            {!! $settings->trans('about_me') !!}
        </div>
    </div>
</section>

{{-- ============================ SKILLS ============================ --}}
<section id="skills" class="scroll-mt-24 bg-slate-50 py-20 dark:bg-slate-900/40">
    <div class="container-x">
        <div class="max-w-2xl" x-reveal>
            <p class="section-eyebrow">{{ __('Skills') }}</p>
            <h2 class="mt-2 text-3xl font-bold sm:text-4xl">{{ __('Tools I build with') }}</h2>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ($skillGroups as $category => $skills)
                <div class="card" x-reveal.delay-{{ $loop->index * 100 }}>
                    <h3 class="text-lg font-semibold">{{ $category }}</h3>
                    <ul class="mt-4 space-y-3">
                        @foreach ($skills as $skill)
                            <li>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-medium text-slate-700 dark:text-slate-200">{{ $skill->name }}</span>
                                    @if ($skill->proficiency)
                                        <span class="text-xs text-slate-400">{{ $skill->proficiency }}%</span>
                                    @endif
                                </div>
                                @if ($skill->proficiency)
                                    <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                                        <div class="h-full rounded-full bg-linear-to-r from-brand-500 to-accent-500" style="width: {{ $skill->proficiency }}%"></div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ======================= FEATURED PROJECTS ======================= --}}
<section id="projects" class="scroll-mt-24 py-20">
    <div class="container-x">
        <div class="flex flex-wrap items-end justify-between gap-4" x-reveal>
            <div class="max-w-2xl">
                <p class="section-eyebrow">{{ __('Projects') }}</p>
                <h2 class="mt-2 text-3xl font-bold sm:text-4xl">{{ __('Featured Projects') }}</h2>
            </div>
            @if ($hasMoreProjects)
                <a href="{{ route('projects.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                    {{ __('View all projects') }} &rarr;
                </a>
            @endif
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($featuredProjects as $project)
                @include('partials.project-card', ['project' => $project])
            @empty
                <p class="prose-body col-span-full">{{ __('No projects yet — check back soon.') }}</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================ RÉSUMÉ ============================ --}}
<section id="resume" class="scroll-mt-24 bg-slate-50 py-20 dark:bg-slate-900/40">
    <div class="container-x grid gap-10 lg:grid-cols-[0.4fr_0.6fr]" x-reveal>
        <div>
            <p class="section-eyebrow">{{ __('Résumé') }}</p>
            <h2 class="mt-2 text-3xl font-bold sm:text-4xl">{{ __('Education & experience') }}</h2>
            <div class="mt-6 flex flex-col gap-3 sm:flex-row lg:flex-col">
                @if ($cvEn)
                    <a href="{{ $cvEn }}" target="_blank" rel="noopener" class="btn-primary">{{ __('Download CV (English)') }}</a>
                @endif
                @if ($cvCkb)
                    <a href="{{ $cvCkb }}" target="_blank" rel="noopener" class="btn-ghost">{{ __('Download CV (Kurdish)') }}</a>
                @endif
            </div>
        </div>
        <div class="prose-body space-y-4 text-lg">
            {!! $settings->trans('resume_summary') !!}
        </div>
    </div>
</section>

{{-- ============================ CONTACT ============================ --}}
<section id="contact" class="scroll-mt-24 py-20">
    <div class="container-x grid gap-10 lg:grid-cols-2" x-reveal>
        <div>
            <p class="section-eyebrow">{{ __('Contact') }}</p>
            <h2 class="mt-2 text-3xl font-bold sm:text-4xl">{{ __("Let's build something") }}</h2>
            <p class="prose-body mt-4 text-lg">{{ __('Have a project in mind or a role to fill? Send a message and I will get back to you.') }}</p>
            @if ($settings->contact_email)
                <a href="mailto:{{ $settings->contact_email }}" class="mt-4 inline-block font-medium text-brand-600 hover:underline dark:text-brand-400">{{ $settings->contact_email }}</a>
            @endif
        </div>

        <div class="card">
            @if (session('contact_status') === 'ok')
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300">
                    {{ __('Thanks — your message has been sent.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
                @csrf
                <div class="hidden" aria-hidden="true">
                    <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium">{{ __('Your name') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 dark:border-slate-700 dark:bg-slate-900">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium">{{ __('Your email') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 dark:border-slate-700 dark:bg-slate-900">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="message" class="mb-1.5 block text-sm font-medium">{{ __('Your message') }}</label>
                    <textarea id="message" name="message" rows="4" required
                              class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30 dark:border-slate-700 dark:bg-slate-900">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-primary w-full">{{ __('Send message') }}</button>
            </form>
        </div>
    </div>
</section>
@endsection
