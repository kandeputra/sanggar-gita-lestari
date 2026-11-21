<x-layouts.site title="Karya Seni" description="Koleksi karya tari, tabuh, dan seni pertunjukan sanggar.">
    <x-page-header eyebrow="Karya Seni" title="Koleksi Karya" subtitle="Tari, tabuh, dan pertunjukan yang lahir dan dirawat di sanggar kami." />

    <section class="container-site py-12">
        <form method="GET" action="{{ route('artworks.index') }}" class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('artworks.index', array_filter(['q' => $search])) }}"
                   @class(['rounded-full px-4 py-2 text-sm font-medium transition', 'bg-bata-800 text-lontar-50' => ! $activeCategory, 'bg-white text-arang/70 ring-1 ring-bata-900/10 hover:bg-lontar-100' => $activeCategory])>Semua</a>
                @foreach ($categories as $key => $label)
                    <a href="{{ route('artworks.index', array_filter(['kategori' => $key, 'q' => $search])) }}"
                       @class(['rounded-full px-4 py-2 text-sm font-medium transition', 'bg-bata-800 text-lontar-50' => $activeCategory === $key, 'bg-white text-arang/70 ring-1 ring-bata-900/10 hover:bg-lontar-100' => $activeCategory !== $key])>{{ $label }}</a>
                @endforeach
            </div>
            @if ($activeCategory)
                <input type="hidden" name="kategori" value="{{ $activeCategory }}">
            @endif
            <label class="relative block lg:w-72">
                <span class="sr-only">Cari karya</span>
                <input type="search" name="q" value="{{ $search }}" placeholder="Cari judul karya…" maxlength="100"
                       class="w-full rounded-full border-0 bg-white px-5 py-2.5 text-sm ring-1 ring-bata-900/15 focus:ring-2 focus:ring-prada-400 focus:outline-none">
            </label>
        </form>

        @if ($artworks->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($artworks as $artwork)
                    <x-artwork-card :artwork="$artwork" />
                @endforeach
            </div>
            <div class="mt-12">{{ $artworks->links() }}</div>
        @else
            <x-empty-state message="Karya tidak ditemukan." />
        @endif
    </section>
</x-layouts.site>
