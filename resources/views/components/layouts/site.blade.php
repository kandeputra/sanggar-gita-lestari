@props(['title' => null, 'description' => null, 'image' => null])

@php
    $pageTitle = $title ? "{$title} — {$profile->name}" : ($profile->tagline ? "{$profile->name} — {$profile->tagline}" : $profile->name);
    $metaDescription = $description ?: ($profile->meta_description ?: $profile->short_description);
    $navigation = [
        ['label' => 'Beranda', 'route' => 'home', 'active' => 'home'],
        ['label' => 'Profil', 'route' => 'profile', 'active' => 'profile'],
        ['label' => 'Seniman', 'route' => 'artists.index', 'active' => 'artists.*'],
        ['label' => 'Karya Seni', 'route' => 'artworks.index', 'active' => 'artworks.*'],
        ['label' => 'Kegiatan', 'route' => 'events.index', 'active' => 'events.*'],
        ['label' => 'Galeri', 'route' => 'gallery', 'active' => 'gallery'],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags((string) $metaDescription), 160) }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags((string) $metaDescription), 160) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($image ?? $profile->fileUrl('hero_image'))
        <meta property="og:image" content="{{ $image ?? $profile->fileUrl('hero_image') }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">
    @if ($profile->logo)
        <link rel="icon" href="{{ $profile->fileUrl('logo') }}">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:500,600,700|plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">
    <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-white focus:px-4 focus:py-2">Lewati ke konten</a>

    {{-- Header --}}
    <header class="sticky top-0 z-40 border-b border-prada-400/20 bg-bata-950/95 text-lontar-100 backdrop-blur">
        <div class="container-site flex h-18 items-center justify-between gap-6 py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if ($profile->logo)
                    <img src="{{ $profile->fileUrl('logo') }}" alt="Logo {{ $profile->name }}" class="h-11 w-11 rounded-full object-cover ring-1 ring-prada-400/40">
                @else
                    <span class="grid h-11 w-11 place-items-center rounded-full bg-prada-400 font-display text-xl font-bold text-bata-950">
                        {{ Str::of($profile->name)->replace('Sanggar ', '')->explode(' ')->map(fn ($word) => Str::substr($word, 0, 1))->take(2)->implode('') }}
                    </span>
                @endif
                <span class="leading-tight">
                    <span class="block font-display text-xl font-semibold tracking-wide text-prada-200">{{ $profile->name }}</span>
                    @if ($profile->tagline)
                        <span class="hidden text-xs text-lontar-100/60 sm:block">{{ $profile->tagline }}</span>
                    @endif
                </span>
            </a>

            <nav class="hidden lg:block" aria-label="Navigasi utama">
                <ul class="flex items-center gap-1 text-sm font-medium">
                    @foreach ($navigation as $item)
                        <li>
                            <a href="{{ route($item['route']) }}"
                               @class([
                                   'rounded-full px-4 py-2 transition',
                                   'bg-prada-400 text-bata-950' => request()->routeIs($item['active']),
                                   'text-lontar-100/80 hover:bg-white/10 hover:text-white' => ! request()->routeIs($item['active']),
                               ])
                               @if (request()->routeIs($item['active'])) aria-current="page" @endif>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <button type="button" class="rounded-lg p-2 text-lontar-100 hover:bg-white/10 lg:hidden" data-menu-toggle aria-controls="menu-mobile" aria-expanded="false">
                <span class="sr-only">Buka menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>

        <nav id="menu-mobile" class="hidden border-t border-white/10 lg:hidden" aria-label="Navigasi mobile">
            <ul class="container-site grid gap-1 py-4">
                @foreach ($navigation as $item)
                    <li>
                        <a href="{{ route($item['route']) }}" @class([
                            'block rounded-lg px-4 py-3',
                            'bg-prada-400 font-semibold text-bata-950' => request()->routeIs($item['active']),
                            'hover:bg-white/10' => ! request()->routeIs($item['active']),
                        ])>{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </header>

    <main id="konten" class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-bata-950 text-lontar-100/80">
        <x-ornament-divider class="text-prada-400/60" />
        <div class="container-site grid gap-10 py-14 md:grid-cols-3">
            <div>
                @if ($profile->script_image)
                    <x-aksara :src="$profile->fileUrl('script_image')" :alt="$profile->name.' dalam aksara Bali'" class="mb-4 w-56 bg-prada-300" />
                @endif
                <p class="font-display text-2xl font-semibold text-prada-200">{{ $profile->name }}</p>
                @if ($profile->short_description)
                    <p class="mt-3 text-sm leading-relaxed">{{ Str::limit($profile->short_description, 180) }}</p>
                @endif
            </div>

            <div>
                <h2 class="font-sans text-sm font-semibold uppercase tracking-[0.2em] text-prada-300">Kontak</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    @if ($profile->address)
                        <li>{{ $profile->address }}</li>
                    @endif
                    @if ($profile->phone)
                        <li>Telp. <a href="tel:{{ $profile->phone }}" class="hover:text-white">{{ $profile->phone }}</a></li>
                    @endif
                    @if ($profile->whatsappLink())
                        <li><a href="{{ $profile->whatsappLink() }}" target="_blank" rel="noopener" class="hover:text-white">WhatsApp {{ $profile->whatsapp }}</a></li>
                    @endif
                    @if ($profile->email)
                        <li><a href="mailto:{{ $profile->email }}" class="hover:text-white">{{ $profile->email }}</a></li>
                    @endif
                </ul>
                @if ($profile->socialLinks())
                    <ul class="mt-5 flex flex-wrap gap-2">
                        @foreach ($profile->socialLinks() as $label => $url)
                            <li><a href="{{ $url }}" target="_blank" rel="noopener" class="inline-block rounded-full border border-prada-400/40 px-3 py-1 text-xs hover:bg-prada-400 hover:text-bata-950">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div>
                <h2 class="font-sans text-sm font-semibold uppercase tracking-[0.2em] text-prada-300">Jelajahi</h2>
                <ul class="mt-4 grid grid-cols-2 gap-2 text-sm">
                    @foreach ($navigation as $item)
                        <li><a href="{{ route($item['route']) }}" class="hover:text-white">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10">
            <p class="container-site py-5 text-xs text-lontar-100/50">&copy; {{ now()->year }} {{ $profile->name }}. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>
</body>
</html>
