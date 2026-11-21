<x-layouts.site title="Galeri" description="Dokumentasi foto latihan, pementasan, dan kegiatan sanggar.">
    <x-page-header eyebrow="Dokumentasi" title="Galeri Sanggar" subtitle="Momen latihan, pementasan, dan kebersamaan keluarga besar sanggar." />

    <section class="container-site py-16">
        @if ($items->isNotEmpty())
            @include('site.partials.photo-grid', ['items' => $items])
            <div class="mt-12">{{ $items->links() }}</div>
        @else
            <x-empty-state message="Belum ada foto yang dipublikasikan." />
        @endif
    </section>
</x-layouts.site>
