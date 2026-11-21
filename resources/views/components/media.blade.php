@props(['src' => null, 'alt' => '', 'label' => null])

{{-- Gambar dengan fallback bermotif bila konten belum punya foto --}}
@if ($src)
    <img src="{{ $src }}" alt="{{ $alt }}" loading="lazy" {{ $attributes->merge(['class' => 'h-full w-full object-cover']) }}>
@else
    <div {{ $attributes->merge(['class' => 'bg-ornament grid h-full w-full place-items-center bg-bata-800 text-prada-300']) }} role="img" aria-label="{{ $alt }}">
        <span class="px-4 text-center font-display text-2xl font-semibold opacity-80">{{ $label ?? Str::limit($alt, 30) }}</span>
    </div>
@endif
