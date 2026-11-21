<x-layouts.site :title="$event->title" :description="$event->excerpt" :image="$event->fileUrl('image')">
    <article>
        <x-page-header :eyebrow="$event->isUpcoming() ? 'Kegiatan Mendatang' : 'Arsip Kegiatan'" :title="$event->title">
            <dl class="mt-8 grid gap-4 text-sm sm:grid-cols-2 lg:max-w-2xl">
                <div class="rounded-xl bg-white/5 p-4 ring-1 ring-white/10">
                    <dt class="text-prada-300">Waktu</dt>
                    <dd class="mt-1 text-lontar-50">
                        {{ $event->starts_at->translatedFormat('l, d F Y · H:i') }} WITA
                        @if ($event->ends_at)
                            <br><span class="text-lontar-100/70">s.d. {{ $event->ends_at->translatedFormat($event->ends_at->isSameDay($event->starts_at) ? 'H:i' : 'd F Y · H:i') }} WITA</span>
                        @endif
                    </dd>
                </div>
                @if ($event->location)
                    <div class="rounded-xl bg-white/5 p-4 ring-1 ring-white/10">
                        <dt class="text-prada-300">Lokasi</dt>
                        <dd class="mt-1 text-lontar-50">{{ $event->location }}</dd>
                    </div>
                @endif
            </dl>
        </x-page-header>

        <div class="container-site grid gap-12 py-16 lg:grid-cols-5">
            <div class="lg:col-span-3">
                @if ($event->excerpt)
                    <p class="mb-6 font-display text-2xl leading-snug text-bata-800">{{ $event->excerpt }}</p>
                @endif
                @if ($event->body)
                    <div class="prose-sanggar">{!! str($event->body)->sanitizeHtml() !!}</div>
                @endif
                <a href="{{ route('events.index') }}" class="mt-10 inline-block text-sm font-semibold text-bata-700 hover:text-bata-900">&larr; Kembali ke agenda</a>
            </div>
            <div class="lg:col-span-2">
                @if ($event->image)
                    <img src="{{ $event->fileUrl('image') }}" alt="{{ $event->title }}" class="w-full rounded-2xl shadow-lg">
                @endif
            </div>
        </div>
    </article>

    @if ($photos->isNotEmpty())
        <section class="bg-lontar-100 py-16">
            <div class="container-site">
                <x-section-heading eyebrow="Dokumentasi" title="Foto Kegiatan" />
                @include('site.partials.photo-grid', ['items' => $photos])
            </div>
        </section>
    @endif
</x-layouts.site>
