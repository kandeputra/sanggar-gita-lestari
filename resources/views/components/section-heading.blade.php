@props(['eyebrow' => null, 'title', 'link' => null, 'linkLabel' => 'Lihat semua', 'dark' => false])

<div {{ $attributes->merge(['class' => 'mb-10 flex flex-wrap items-end justify-between gap-4']) }}>
    <div>
        @if ($eyebrow)
            <p @class(['text-xs font-semibold uppercase tracking-[0.25em]', 'text-prada-300' => $dark, 'text-bata-600' => ! $dark])>{{ $eyebrow }}</p>
        @endif
        <h2 @class(['mt-2 text-4xl font-semibold sm:text-5xl', 'text-lontar-50' => $dark, 'text-bata-900' => ! $dark])>{{ $title }}</h2>
    </div>
    @if ($link)
        <a href="{{ $link }}" @class(['group inline-flex items-center gap-2 text-sm font-semibold', 'text-prada-300 hover:text-prada-200' => $dark, 'text-bata-700 hover:text-bata-900' => ! $dark])>
            {{ $linkLabel }}
            <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span>
        </a>
    @endif
</div>
