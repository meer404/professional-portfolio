@php
    $thumb = optional($project->getFirstMedia('screenshots'));
    $thumbUrl = $thumb && $thumb->id ? $thumb->getUrl('thumb') : null;
@endphp

<a href="{{ route('projects.show', $project) }}"
   class="card group flex flex-col gap-3 p-3 frame-lift"
   x-reveal>
    <x-window-frame :label="$project->title">
        @if ($thumbUrl)
            <img src="{{ $thumbUrl }}" alt="" loading="lazy" class="h-full w-full object-cover">
        @else
            <div class="grid h-full w-full place-items-center bg-linear-to-br from-brand-100 to-accent-100 dark:from-slate-800 dark:to-slate-800">
                <img src="{{ asset('brand/mir-icon-purple.svg') }}" alt="" class="h-10 w-10 opacity-40 dark:hidden">
                <img src="{{ asset('brand/mir-icon-white.svg') }}" alt="" class="hidden h-10 w-10 opacity-40 dark:block">
            </div>
        @endif
    </x-window-frame>

    <div class="flex flex-1 flex-col p-2">
        <h3 class="font-display text-lg font-semibold text-slate-900 group-hover:text-brand-700 dark:text-white dark:group-hover:text-brand-300">
            {{ $project->title }}
        </h3>
        <p class="prose-body mt-2 line-clamp-3 flex-1 text-sm">
            {{ $project->problem }}
        </p>
        <div class="mt-4 flex flex-wrap gap-1.5">
            @foreach (array_slice($project->tech_stack ?? [], 0, 4) as $tech)
                <span class="badge">{{ $tech }}</span>
            @endforeach
        </div>
        <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-600 dark:text-brand-400">
            {{ __('Read case study') }}
            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
        </span>
    </div>
</a>
