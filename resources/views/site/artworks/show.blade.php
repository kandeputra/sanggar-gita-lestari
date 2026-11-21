<x-layouts.site :title="$artwork->title" :description="$artwork->excerpt" :image="$artwork->fileUrl('image')">
    <article>
        <x-page-header :eyebrow="$artwork->categoryLabel()" :title="$artwork->title" :subtitle="$artwork->excerpt">
            <p class="mt-6 text-sm text-lontar-100/70">
                @if ($artwork->artist)
                    Karya <a href="{{ route('artists.show', $artwork->artist) }}" class="font-semibold text-prada-200 hover:underline">{{ $artwork->artist->name }}</a>
                @endif
                @if ($artwork->year) · {{ $artwork->year }} @endif
            </p>
        </x-page-header>

        <div class="container-site grid gap-12 py-16 lg:grid-cols-5">
            <div class="lg:col-span-3">
                @if ($artwork->youtubeEmbedUrl())
                    <div class="mb-8 aspect-video overflow-hidden rounded-2xl bg-black">
                        <iframe src="{{ $artwork->youtubeEmbedUrl() }}" class="h-full w-full" title="Video {{ $artwork->title }}" loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                @endif
                @if ($artwork->description)
                    <div class="prose-sanggar">{!! str($artwork->description)->sanitizeHtml() !!}</div>
                @endif
            </div>
            <div class="lg:col-span-2">
                <div class="sticky top-28 overflow-hidden rounded-2xl shadow-lg">
                    <div class="aspect-[4/5]">
                        <x-media :src="$artwork->fileUrl('image')" :alt="$artwork->title" />
                    </div>
                </div>
            </div>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-lontar-100 py-16">
            <div class="container-site">
                <x-section-heading eyebrow="Kategori serupa" title="Karya Lainnya" :link="route('artworks.index', ['kategori' => $artwork->category])" />
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-artwork-card :artwork="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.site>
