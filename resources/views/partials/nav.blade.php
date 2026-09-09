@php
    $locale = app()->getLocale();
    $navLinks = [
        ['label' => __('About'), 'href' => route('home') . '#about', 'section' => 'about'],
        ['label' => __('Résumé'), 'href' => route('home') . '#resume', 'section' => 'resume'],
        ['label' => __('Skills'), 'href' => route('home') . '#skills', 'section' => 'skills'],
        ['label' => __('Projects'), 'href' => route('projects.index'), 'section' => 'projects'],
        ['label' => __('Contact'), 'href' => route('home') . '#contact', 'section' => 'contact'],
    ];
    $initialSection = request()->routeIs('projects.*') ? 'projects' : '';
@endphp

<header
    x-data="{ scrolled: false, open: false, activeSection: '{{ $initialSection }}' }"
    x-init="
        const ids = ['about', 'resume', 'skills', 'projects', 'contact'];
        if (document.getElementById('about')) {
            const present = ids.filter((id) => document.getElementById(id));
            const spy = () => {
                let current = '';
                if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2) {
                    current = present[present.length - 1] || '';
                } else {
                    const line = window.innerHeight * 0.3;
                    for (const id of present) {
                        if (document.getElementById(id).getBoundingClientRect().top <= line) current = id;
                    }
                }
                activeSection = current;
            };
            spy();
            window.addEventListener('scroll', spy, { passive: true });
            window.addEventListener('resize', spy, { passive: true });
        }
    "
    @scroll.window="scrolled = window.scrollY > 12"
    :class="scrolled ? 'border-slate-200/70 bg-white/80 shadow-sm backdrop-blur-lg dark:border-slate-800/70 dark:bg-slate-950/80' : 'border-transparent bg-transparent'"
    class="fixed inset-x-0 top-0 z-40 border-b transition-all duration-300"
>
    <nav class="container-x flex h-16 items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="group flex items-center transition-transform hover:scale-[1.03]" aria-label="{{ $settings->name }}">
            <img src="{{ asset('brand/mir-mark-purple.svg') }}" alt="{{ $settings->name }}" class="h-7 w-auto dark:hidden">
            <img src="{{ asset('brand/mir-mark-white.svg') }}" alt="{{ $settings->name }}" class="hidden h-7 w-auto dark:block">
        </a>

        <div class="hidden items-center gap-1 md:flex">
            @foreach ($navLinks as $link)
                <a href="{{ $link['href'] }}"
                   :aria-current="activeSection === '{{ $link['section'] }}' ? 'page' : null"
                   :class="activeSection === '{{ $link['section'] }}'
                       ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-white'
                       : 'text-slate-600 hover:bg-slate-100 hover:text-brand-700 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white'"
                   class="rounded-lg px-3 py-2 text-sm font-medium transition-colors">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-1.5">
            {{-- Language switcher --}}
            <div class="flex items-center rounded-lg border border-slate-200 p-0.5 text-xs font-semibold dark:border-slate-700">
                @foreach (['en' => 'EN', 'ckb' => 'کوردی'] as $code => $label)
                    <a href="{{ route('language.switch', $code) }}"
                       class="rounded-md px-2 py-1 transition-colors {{ $locale === $code ? 'bg-brand-600 text-white' : 'text-slate-500 hover:text-brand-700 dark:text-slate-400 dark:hover:text-white' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Dark mode toggle --}}
            <button type="button"
                @click="$store.theme.toggle()"
                :aria-pressed="$store.theme.dark"
                aria-label="{{ __('Toggle theme') }}"
                class="grid h-9 w-9 place-items-center rounded-lg border border-slate-200 text-slate-600 transition-colors hover:text-brand-700 dark:border-slate-700 dark:text-slate-300 dark:hover:text-white">
                <svg x-show="!$store.theme.dark" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" /></svg>
                <svg x-show="$store.theme.dark" x-cloak class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
            </button>

            {{-- Mobile menu button --}}
            <button type="button" @click="open = true" class="grid h-9 w-9 place-items-center rounded-lg border border-slate-200 text-slate-600 md:hidden dark:border-slate-700 dark:text-slate-300" aria-label="{{ __('Menu') }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>
        </div>

        {{-- Mobile slide-over --}}
        <div x-show="open" x-cloak class="fixed inset-0 z-50 md:hidden">
            <div x-show="open" x-transition.opacity @click="open = false" class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm"></div>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-x-full rtl:-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full rtl:-translate-x-full"
                 class="absolute inset-y-0 end-0 w-72 max-w-[80%] bg-white p-6 shadow-xl dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <img src="{{ asset('brand/mir-mark-purple.svg') }}" alt="{{ $settings->name }}" class="h-6 w-auto dark:hidden">
                    <img src="{{ asset('brand/mir-mark-white.svg') }}" alt="{{ $settings->name }}" class="hidden h-6 w-auto dark:block">
                    <button @click="open = false" class="grid h-9 w-9 place-items-center rounded-lg text-slate-500" aria-label="Close">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="mt-6 flex flex-col gap-1">
                    @foreach ($navLinks as $link)
                        <a href="{{ $link['href'] }}" @click="open = false"
                           :aria-current="activeSection === '{{ $link['section'] }}' ? 'page' : null"
                           :class="activeSection === '{{ $link['section'] }}'
                               ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-white'
                               : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800'"
                           class="rounded-lg px-3 py-2.5 text-base font-medium">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>
</header>
