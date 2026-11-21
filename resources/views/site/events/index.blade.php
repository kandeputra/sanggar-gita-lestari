<x-layouts.site title="Kegiatan" description="Agenda latihan, pementasan, dan kegiatan sanggar.">
    <x-page-header eyebrow="Agenda" title="Kegiatan Sanggar" subtitle="Pementasan, latihan bersama, workshop, dan ngayah di pura." />

    <section class="container-site py-12">
        <div class="mb-10 inline-flex rounded-full bg-white p-1 ring-1 ring-bata-900/10" role="tablist">
            @foreach (['mendatang' => 'Akan Datang', 'selesai' => 'Telah Berlangsung'] as $key => $label)
                <a href="{{ route('events.index', ['waktu' => $key]) }}" role="tab" aria-selected="{{ $period === $key ? 'true' : 'false' }}"
                   @class(['rounded-full px-5 py-2 text-sm font-semibold transition', 'bg-bata-800 text-lontar-50' => $period === $key, 'text-arang/60 hover:text-arang' => $period !== $key])>{{ $label }}</a>
            @endforeach
        </div>

        @if ($events->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
            <div class="mt-12">{{ $events->links() }}</div>
        @else
            <x-empty-state :message="$period === 'mendatang' ? 'Belum ada kegiatan terjadwal.' : 'Belum ada arsip kegiatan.'" />
        @endif
    </section>
</x-layouts.site>
