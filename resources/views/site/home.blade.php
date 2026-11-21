<x-layouts.site>
    {{-- Hero --}}
    <section class="relative isolate overflow-hidden bg-bata-950 text-lontar-50">
        @if ($profile->hero_image)
            <img src="{{ $profile->fileUrl('hero_image') }}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover opacity-35">
        @endif
        <div class="bg-ornament absolute inset-0 -z-10 opacity-70"></div>
        <div class="absolute inset-x-0 bottom-0 -z-10 h-40 bg-gradient-to-t from-bata-950"></div>

        <div class="container-site flex min-h-[78vh] flex-col items-center justify-center py-24 text-center">
            @if ($profile->script_image)
                <x-aksara :src="$profile->fileUrl('script_image')" :alt="$profile->name.' dalam aksara Bali'" class="w-full max-w-xl bg-prada-300" />
                <x-ornament-divider class="mt-6 text-prada-400/70" />
            @endif
            <h1 class="mt-4 text-5xl font-semibold leading-tight text-lontar-50 sm:text-7xl">{{ $profile->name }}</h1>
            @if ($profile->tagline)
                <p class="mt-4 text-sm font-semibold uppercase tracking-[0.3em] text-prada-300">{{ $profile->tagline }}</p>
            @endif
            @if ($profile->short_description)
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-lontar-100/80">{{ $profile->short_description }}</p>
            @endif
            <div class="mt-10 flex flex-wrap justify-center gap-3">
                <a href="{{ route('artworks.index') }}" class="rounded-full bg-prada-400 px-7 py-3 font-semibold text-bata-950 transition hover:bg-prada-300">Lihat Karya Seni</a>
                <a href="{{ route('events.index') }}" class="rounded-full border border-lontar-100/40 px-7 py-3 font-semibold text-lontar-50 transition hover:bg-white/10">Jadwal Kegiatan</a>
            </div>
        </div>
    </section>

    {{-- Sambutan pimpinan --}}
    @if ($profile->leader_name || $profile->leader_message)
        <section class="container-site grid items-center gap-12 py-20 md:grid-cols-5">
            <div class="md:col-span-2">
                <div class="relative mx-auto max-w-sm">
                    <div class="absolute -inset-3 rounded-t-full rounded-b-3xl border-2 border-prada-400/50"></div>
                    <div class="relative aspect-[4/5] overflow-hidden rounded-t-full rounded-b-3xl">
                        <x-media :src="$profile->fileUrl('leader_photo')" :alt="$profile->leader_name ?? 'Pimpinan sanggar'" />
                    </div>
                </div>
            </div>
            <div class="md:col-span-3">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-bata-600">Sambutan</p>
                <h2 class="mt-2 text-4xl font-semibold text-bata-900 sm:text-5xl">Merawat warisan, menumbuhkan generasi</h2>
                @if ($profile->leader_message)
                    <blockquote class="mt-6 border-l-4 border-prada-400 pl-5 text-lg leading-relaxed text-arang/80">
                        {!! nl2br(e($profile->leader_message)) !!}
                    </blockquote>
                @endif
                @if ($profile->leader_name)
                    <p class="mt-6 font-display text-2xl font-semibold text-bata-800">{{ $profile->leader_name }}</p>
                    <p class="text-sm text-arang/60">{{ $profile->leader_title }}</p>
                @endif
                <a href="{{ route('profile') }}" class="mt-8 inline-flex items-center gap-2 font-semibold text-bata-700 hover:text-bata-900">Kenali sanggar kami <span aria-hidden="true">&rarr;</span></a>
            </div>
        </section>
    @endif

    {{-- Kegiatan mendatang --}}
    <section class="bg-lontar-100 py-20">
        <div class="container-site">
            <x-section-heading eyebrow="Agenda" title="Kegiatan Mendatang" :link="route('events.index')" />
            @if ($upcomingEvents->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($upcomingEvents as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
            @else
                <x-empty-state message="Belum ada jadwal kegiatan terdekat. Nantikan informasi selanjutnya." />
            @endif
        </div>
    </section>

    {{-- Karya --}}
    <section class="container-site py-20">
        <x-section-heading eyebrow="Karya" title="Karya Seni Sanggar" :link="route('artworks.index')" />
        @if ($featuredArtworks->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredArtworks as $artwork)
                    <x-artwork-card :artwork="$artwork" />
                @endforeach
            </div>
        @else
            <x-empty-state />
        @endif
    </section>

    {{-- Seniman --}}
    @if ($artists->isNotEmpty())
        <section class="relative overflow-hidden bg-bata-900 py-20">
            <div class="bg-ornament absolute inset-0 opacity-50"></div>
            <div class="container-site relative">
                <x-section-heading eyebrow="Para Seniman" title="Penjaga Tradisi" :link="route('artists.index')" dark />
                <div class="grid grid-cols-2 gap-8 md:grid-cols-4 [&_h3]:text-lontar-50 [&_p]:text-lontar-100/60">
                    @foreach ($artists as $artist)
                        <x-artist-card :artist="$artist" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Galeri --}}
    @if ($galleryItems->isNotEmpty())
        <section class="container-site py-20">
            <x-section-heading eyebrow="Dokumentasi" title="Galeri" :link="route('gallery')" />
            <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
                @foreach ($galleryItems as $item)
                    <a href="{{ route('gallery') }}" @class(['group relative overflow-hidden rounded-xl', 'md:col-span-2 md:row-span-2' => $loop->first])>
                        <img src="{{ $item->fileUrl('image') }}" alt="{{ $item->title }}" loading="lazy" class="aspect-square h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Ajakan --}}
    @if ($profile->whatsappLink())
        <section class="container-site pb-20">
            <div class="relative overflow-hidden rounded-3xl bg-prada-400 px-8 py-14 text-center text-bata-950 sm:px-16">
                <h2 class="text-4xl font-semibold sm:text-5xl">Ingin belajar menari atau mengundang pentas?</h2>
                <p class="mx-auto mt-4 max-w-xl text-bata-950/75">Hubungi kami untuk informasi pendaftaran kelas, jadwal latihan, maupun undangan pementasan.</p>
                <a href="{{ $profile->whatsappLink() }}" target="_blank" rel="noopener" class="mt-8 inline-block rounded-full bg-bata-950 px-8 py-3 font-semibold text-prada-200 transition hover:bg-bata-800">Hubungi via WhatsApp</a>
            </div>
        </section>
    @endif
</x-layouts.site>
