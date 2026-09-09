@props(['clients'])

@php
    // Duplicate / pad the list in PHP so the CSS -50% loop is seamless even with only a few clients.
    $items = collect($clients)->values();
    $base = $items;

    while ($base->isNotEmpty() && $items->count() < 16) {
        $items = $items->concat($base);
    }
    $items = $items->values();

    $rowOne = $items;
    $rowTwo = $items->reverse()->values();

    $isRtl = in_array(app()->getLocale(), \App\Http\Middleware\SetLocale::RTL, true);

    $rows = [
        ['items' => $rowOne, 'reverse' => false],
        ['items' => $rowTwo, 'reverse' => true],
    ];
@endphp

@if ($items->isNotEmpty())
    <div {{ $attributes->class(['client-marquee', 'client-marquee--rtl' => $isRtl]) }}>
        @foreach ($rows as $row)
            <div class="client-marquee__viewport">
                <div class="client-marquee__track @if ($row['reverse']) client-marquee__track--reverse @endif">
                    {{-- Rendered twice: the second copy is the seamless-loop tail. --}}
                    @foreach ($row['items'] as $client)
                        @include('partials.client-logo', ['client' => $client])
                    @endforeach
                    @foreach ($row['items'] as $client)
                        @include('partials.client-logo', ['client' => $client, 'duplicate' => true])
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endif
