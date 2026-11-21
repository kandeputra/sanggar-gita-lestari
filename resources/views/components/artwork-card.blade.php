@props(['artwork'])

<article class="group overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-bata-900/5 transition hover:-translate-y-1 hover:shadow-lg">
    <a href="{{ route('artworks.show', $artwork) }}" class="block">
        <div class="aspect-[4/3] overflow-hidden">
            <x-media :src="$artwork->fileUrl('image')" :alt="$artwork->title" class="transition duration-500 group-hover:scale-105" />
        </div>
        <div class="p-5">
            <p class="text-xs font-semibold uppercase tracking-widest text-prada-600">{{ $artwork->categoryLabel() }}@if ($artwork->year) · {{ $artwork->year }}@endif</p>
            <h3 class="mt-2 text-2xl font-semibold text-bata-900">{{ $artwork->title }}</h3>
            @if ($artwork->relationLoaded('artist') && $artwork->artist)
                <p class="mt-1 text-sm text-arang/60">oleh {{ $artwork->artist->name }}</p>
            @endif
        </div>
    </a>
</article>
