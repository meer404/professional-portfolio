@props([
    'label' => null,
    'tone' => 'auto',   {{-- 'auto' = paper/ink chrome ; 'dark' = force ink chrome (lightbox) --}}
    'ratio' => '16/9',  {{-- '16/9' = fixed media well (grids) ; 'auto' = shrink-wrap (lightbox) --}}
])

@php
    $rtl = in_array(app()->getLocale(), \App\Http\Middleware\SetLocale::RTL, true);
@endphp

<div {{ $attributes->class([
        'overflow-hidden rounded-xl border shadow-[0_14px_40px_-16px_rgba(20,18,31,0.22)]',
        'border-line bg-paper dark:border-line-dark dark:bg-ink dark:shadow-[0_14px_40px_-16px_rgba(0,0,0,0.55)]' => $tone === 'auto',
        'border-line-dark bg-ink shadow-[0_14px_40px_-16px_rgba(0,0,0,0.55)]' => $tone === 'dark',
    ]) }}>
    <div @class([
        'flex items-center gap-2 border-b px-3 py-2',
        'border-line dark:border-line-dark' => $tone === 'auto',
        'border-line-dark' => $tone === 'dark',
    ])>
        <span class="flex shrink-0 gap-1.5">
            <span class="h-3 w-3 rounded-full bg-[#FF5F57]"></span>
            <span class="h-3 w-3 rounded-full bg-[#FEBC2E]"></span>
            <span class="h-3 w-3 rounded-full bg-[#28C840]"></span>
        </span>
        @if (filled($label))
            <span @class([
                'truncate text-[11px] leading-none',
                'text-slate-500 dark:text-slate-400' => $tone === 'auto',
                'text-slate-400' => $tone === 'dark',
                'font-mono' => ! $rtl,
                'font-kurdish' => $rtl,
            ])>{{ $label }}</span>
        @endif
    </div>

    @if ($ratio === 'auto')
        <div class="flex items-center justify-center">{{ $slot }}</div>
    @else
        <div class="aspect-video overflow-hidden">{{ $slot }}</div>
    @endif
</div>
