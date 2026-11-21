@props(['event'])

<article class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-bata-900/5 transition hover:shadow-lg">
    <a href="{{ route('events.show', $event) }}" class="relative block aspect-[16/10] overflow-hidden">
        <x-media :src="$event->fileUrl('image')" :alt="$event->title" class="transition duration-500 group-hover:scale-105" />
        <div class="absolute left-4 top-4 rounded-xl bg-lontar-50 px-3 py-2 text-center shadow">
            <span class="block font-display text-3xl font-bold leading-none text-bata-700">{{ $event->starts_at->format('d') }}</span>
            <span class="block text-[0.7rem] font-semibold uppercase tracking-wider text-arang/70">{{ $event->starts_at->translatedFormat('M Y') }}</span>
        </div>
    </a>
    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-2xl font-semibold text-bata-900">
            <a href="{{ route('events.show', $event) }}" class="hover:text-bata-600">{{ $event->title }}</a>
        </h3>
        <p class="mt-2 text-sm text-arang/60">
            {{ $event->starts_at->translatedFormat('l, d F Y · H:i') }} WITA
            @if ($event->location)<br>{{ $event->location }}@endif
        </p>
        @if ($event->excerpt)
            <p class="mt-3 text-sm leading-relaxed text-arang/75">{{ Str::limit($event->excerpt, 120) }}</p>
        @endif
    </div>
</article>
