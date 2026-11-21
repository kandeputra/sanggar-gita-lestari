<x-layouts.site title="Profil" :description="$profile->short_description">
    <x-page-header eyebrow="Tentang Kami" :title="$profile->name" :subtitle="$profile->tagline">
        @if ($profile->founded_year)
            <p class="mt-6 inline-block rounded-full border border-prada-400/40 px-4 py-1 text-sm text-prada-200">Berdiri sejak {{ $profile->founded_year }}</p>
        @endif
    </x-page-header>

    <section class="container-site grid gap-14 py-20 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <h2 class="text-4xl font-semibold text-bata-900">Sejarah Sanggar</h2>
            <x-ornament-divider class="my-4 justify-start text-prada-500" />
            @if ($profile->history)
                <div class="prose-sanggar">{!! str($profile->history)->sanitizeHtml() !!}</div>
            @else
                <p class="text-arang/60">Sejarah sanggar belum diisi.</p>
            @endif
        </div>

        <aside class="space-y-6">
            @if ($profile->leader_name)
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-bata-900/5">
                    <div class="aspect-[4/3]">
                        <x-media :src="$profile->fileUrl('leader_photo')" :alt="$profile->leader_name" />
                    </div>
                    <div class="p-6">
                        <p class="font-display text-2xl font-semibold text-bata-900">{{ $profile->leader_name }}</p>
                        <p class="text-sm text-arang/60">{{ $profile->leader_title }}</p>
                    </div>
                </div>
            @endif

            @if ($profile->vision)
                <div class="rounded-2xl bg-bata-900 p-6 text-lontar-100">
                    <h3 class="text-3xl font-semibold text-prada-200">Visi</h3>
                    <p class="mt-3 leading-relaxed">{{ $profile->vision }}</p>
                </div>
            @endif

            @if ($profile->mission)
                <div class="rounded-2xl bg-lontar-100 p-6">
                    <h3 class="text-3xl font-semibold text-bata-900">Misi</h3>
                    <ol class="mt-3 space-y-3">
                        @foreach (preg_split('/\r\n|\r|\n/', trim($profile->mission)) as $mission)
                            @continue(blank($mission))
                            <li class="flex gap-3">
                                <span class="mt-1 grid h-6 w-6 shrink-0 place-items-center rounded-full bg-prada-400 text-xs font-bold text-bata-950">{{ $loop->iteration }}</span>
                                <span class="leading-relaxed text-arang/80">{{ $mission }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif
        </aside>
    </section>

    @if ($artists->isNotEmpty())
        <section class="bg-lontar-100 py-20">
            <div class="container-site">
                <x-section-heading eyebrow="Keluarga Besar" title="Seniman & Pelatih" :link="route('artists.index')" />
                <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                    @foreach ($artists as $artist)
                        <x-artist-card :artist="$artist" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($profile->maps_embed_url)
        <section class="container-site py-20">
            <x-section-heading eyebrow="Lokasi" title="Kunjungi Sanggar" />
            <div class="aspect-[16/7] overflow-hidden rounded-2xl ring-1 ring-bata-900/10">
                <iframe src="{{ $profile->maps_embed_url }}" class="h-full w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta lokasi {{ $profile->name }}"></iframe>
            </div>
            @if ($profile->address)
                <p class="mt-4 text-arang/70">{{ $profile->address }}</p>
            @endif
        </section>
    @endif
</x-layouts.site>
