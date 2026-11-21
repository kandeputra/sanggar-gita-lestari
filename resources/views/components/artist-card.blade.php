@props(['artist'])

<article class="group text-center">
    <a href="{{ route('artists.show', $artist) }}" class="block">
        <div class="mx-auto aspect-[3/4] overflow-hidden rounded-t-full rounded-b-2xl ring-4 ring-prada-400/30 transition group-hover:ring-prada-400">
            <x-media :src="$artist->fileUrl('photo')" :alt="$artist->name" :label="Str::substr($artist->name, 0, 1)" class="transition duration-500 group-hover:scale-105" />
        </div>
        <h3 class="mt-4 text-2xl font-semibold text-bata-900">{{ $artist->name }}</h3>
        @if ($artist->specialty)
            <p class="text-sm text-arang/60">{{ $artist->specialty }}</p>
        @endif
    </a>
</article>
