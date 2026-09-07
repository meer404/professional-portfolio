@extends('layouts.app')

@section('title', __('Projects') . ' — ' . $settings->name)

@section('content')
<section class="pt-28 pb-16 sm:pt-36">
    <div class="container-x">
        <div class="max-w-2xl" x-reveal>
            <p class="section-eyebrow">{{ __('Projects') }}</p>
            <h1 class="mt-2 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ __('Case studies') }}</h1>
            <p class="prose-body mt-4 text-lg">
                {{ __('A closer look at problems I set out to solve — and what shipped.') }}
            </p>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($projects as $project)
                @include('partials.project-card', ['project' => $project])
            @empty
                <p class="prose-body col-span-full">{{ __('No projects yet — check back soon.') }}</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
