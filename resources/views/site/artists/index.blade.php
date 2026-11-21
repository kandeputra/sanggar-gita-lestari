<x-layouts.site title="Seniman" description="Para seniman, penari, penabuh, dan pelatih yang berkarya bersama sanggar.">
    <x-page-header eyebrow="Seniman" title="Para Seniman Sanggar" subtitle="Penari, penabuh, dan pelatih yang menjaga napas seni tradisi Bali." />

    <section class="container-site py-16">
        @if ($artists->isNotEmpty())
            <div class="grid grid-cols-2 gap-x-6 gap-y-12 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($artists as $artist)
                    <x-artist-card :artist="$artist" />
                @endforeach
            </div>
            <div class="mt-12">{{ $artists->links() }}</div>
        @else
            <x-empty-state message="Data seniman belum dipublikasikan." />
        @endif
    </section>
</x-layouts.site>
