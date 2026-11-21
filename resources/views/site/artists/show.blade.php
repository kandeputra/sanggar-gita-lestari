<x-layouts.site :title="$artist->name" :description="Str::limit((string) $artist->bio, 160)" :image="$artist->fileUrl('photo')">
    <section class="relative overflow-hidden bg-bata-900 text-lontar-50">
        <div class="bg-ornament absolute inset-0 opacity-50"></div>
        <div class="container-site relative grid items-center gap-10 py-16 md:grid-cols-3">
            <div class="mx-auto w-56 md:w-full">
                <div class="aspect-[3/4] overflow-hidden rounded-t-full rounded-b-2xl ring-4 ring-prada-400/50">
                    <x-media :src="$artist->fileUrl('photo')" :alt="$artist->name" :label="Str::substr($artist->name, 0, 1)" />
                </div>
            </div>
            <div class="md:col-span-2">
                <a href="{{ route('artists.index') }}" class="text-sm text-prada-300 hover:text-prada-200">&larr; Semua seniman</a>
                <h1 class="mt-4 text-5xl font-semibold sm:text-6xl">{{ $artist->name }}</h1>
                @if ($artist->specialty)
                    <p class="mt-3 text-sm font-semibold uppercase tracking-[0.25em] text-prada-300">{{ $artist->specialty }}</p>
                @endif
                @if ($artist->bio)
                    <p class="mt-6 max-w-2xl text-lg leading-relaxed text-lontar-100/80">{!! nl2br(e($artist->bio)) !!}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="container-site py-16">
        <x-section-heading eyebrow="Karya" title="Karya {{ $artist->name }}" />
        @if ($artworks->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($artworks as $artwork)
                    <x-artwork-card :artwork="$artwork" />
                @endforeach
            </div>
        @else
            <x-empty-state message="Belum ada karya yang dipublikasikan untuk seniman ini." />
        @endif
    </section>
</x-layouts.site>
