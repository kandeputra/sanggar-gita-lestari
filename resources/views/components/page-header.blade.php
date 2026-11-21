@props(['title', 'subtitle' => null, 'eyebrow' => null])

<section class="relative overflow-hidden bg-bata-900 text-lontar-50">
    <div class="bg-ornament absolute inset-0 opacity-60"></div>
    <div class="container-site relative py-16 sm:py-20">
        @if ($eyebrow)
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-prada-300">{{ $eyebrow }}</p>
        @endif
        <h1 class="mt-3 max-w-3xl text-5xl font-semibold leading-tight sm:text-6xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-4 max-w-2xl text-lg text-lontar-100/75">{{ $subtitle }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
