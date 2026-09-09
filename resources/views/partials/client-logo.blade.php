@php
    $logoUrl = $client->logoUrl();
    $isDuplicate = $duplicate ?? false;
@endphp

<a
    @if ($client->website_url)
        href="{{ $client->website_url }}" target="_blank" rel="noopener noreferrer"
    @endif
    @if ($isDuplicate) aria-hidden="true" tabindex="-1" @endif
    class="group flex w-40 shrink-0 flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-5 py-6 text-center transition-colors duration-300 hover:border-brand-300 dark:border-white/10 dark:bg-white/[0.04] dark:hover:border-brand-500/40"
>
    <span class="flex h-11 w-full items-center justify-center">
        @if ($logoUrl)
            <img src="{{ $logoUrl }}" alt="{{ $client->name }}" loading="lazy"
                 class="max-h-11 w-auto max-w-[110px] object-contain grayscale transition duration-300 group-hover:grayscale-0">
        @else
            <span class="grid h-11 w-11 place-items-center rounded-lg bg-slate-200 text-sm font-bold text-slate-500 transition-colors duration-300 group-hover:bg-brand-500 group-hover:text-white dark:bg-white/10 dark:text-slate-300">
                {{ $client->initials() }}
            </span>
        @endif
    </span>

    <span class="block w-full truncate text-xs font-medium text-slate-500 transition-colors duration-300 group-hover:text-slate-900 dark:text-slate-400 dark:group-hover:text-white">
        {{ $client->name }}
    </span>
</a>
