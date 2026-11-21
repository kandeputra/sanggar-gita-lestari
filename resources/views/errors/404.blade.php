<x-layouts.site title="Halaman tidak ditemukan">
    <section class="container-site flex min-h-[60vh] flex-col items-center justify-center py-20 text-center">
        <p class="font-display text-8xl font-bold text-prada-400">404</p>
        <x-ornament-divider class="my-4 text-bata-400" />
        <h1 class="text-4xl font-semibold text-bata-900">Halaman tidak ditemukan</h1>
        <p class="mt-3 text-arang/60">Konten yang Anda cari mungkin sudah dipindahkan atau belum dipublikasikan.</p>
        <a href="{{ route('home') }}" class="mt-8 rounded-full bg-bata-800 px-6 py-3 font-semibold text-lontar-50 hover:bg-bata-700">Kembali ke Beranda</a>
    </section>
</x-layouts.site>
