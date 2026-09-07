@php
    $thumb = optional($project->getFirstMedia('screenshots'));
    $thumbUrl = $thumb && $thumb->id ? $thumb->getUrl('thumb') : null;
@endphp

<a href="{{ route('projects.show', $project) }}"
   class="card group flex flex-col overflow-hidden !p-0 hover:-translate-y-1 hover:border-brand-300 hover:shadow-xl hover:shadow-brand-600/10 dark:hover:border-brand-700"
   x-reveal>
    <div class="aspect-video overflow-hidden bg-linear-to-br from-brand-100 to-accent-100 dark:from-slate-800 dark:to-slate-800">
        @if ($thumbUrl)
            <img src="{{ $thumbUrl }}" alt="" loading="lazy"
                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="grid h-full w-full place-items-center font-display text-3xl font-bold text-brand-500/60">
                {{ Str::limit($project->title, 18) }}
            </div>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
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
