<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use Illuminate\Database\Seeder;

/**
 * Contoh konten awal agar website tidak kosong. Aman dihapus/diubah lewat dashboard.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        if (Artist::query()->exists()) {
            return;
        }

        $published = ContentStatus::Published;

        $pelatihTari = Artist::query()->create([
            'name' => 'Pelatih Tari',
            'specialty' => 'Pelatih Tari Bali',
            'bio' => 'Contoh data seniman. Ubah nama, foto, dan biografi melalui menu Seniman di dashboard.',
            'sort_order' => 1,
            'status' => $published,
        ]);

        $pelatihTabuh = Artist::query()->create([
            'name' => 'Pelatih Tabuh',
            'specialty' => 'Penabuh Kendang & Pelatih Gamelan',
            'bio' => 'Contoh data seniman. Ubah nama, foto, dan biografi melalui menu Seniman di dashboard.',
            'sort_order' => 2,
            'status' => $published,
        ]);

        $artworks = [
            ['Tari Pendet', 'tari', $pelatihTari, 'Tari penyambutan yang menggambarkan suka cita dan persembahan bunga.'],
            ['Tari Puspanjali', 'tari', $pelatihTari, 'Tari penyambutan yang dibawakan secara berkelompok oleh penari putri.'],
            ['Tari Baris Tunggal', 'tari', $pelatihTari, 'Tari putra yang menggambarkan ketangkasan dan keberanian prajurit Bali.'],
            ['Tabuh Gilak', 'tabuh', $pelatihTabuh, 'Komposisi gamelan pengiring yang penuh semangat.'],
        ];

        foreach ($artworks as $index => [$title, $category, $artist, $excerpt]) {
            Artwork::query()->create([
                'artist_id' => $artist->id,
                'title' => $title,
                'category' => $category,
                'excerpt' => $excerpt,
                'description' => "<p>{$excerpt}</p><p>Lengkapi deskripsi, foto, dan video karya ini melalui menu Karya Seni di dashboard.</p>",
                'is_featured' => $index < 3,
                'status' => $published,
            ]);
        }

        Event::query()->create([
            'title' => 'Latihan Rutin Tari Anak',
            'excerpt' => 'Latihan rutin mingguan untuk kelas tari anak-anak.',
            'body' => '<p>Contoh kegiatan. Ubah atau hapus melalui menu Kegiatan di dashboard.</p>',
            'location' => 'Sanggar Gita Lestari',
            'starts_at' => now()->next('Sunday')->setTime(15, 0),
            'ends_at' => now()->next('Sunday')->setTime(17, 0),
            'status' => $published,
        ]);

        Event::query()->create([
            'title' => 'Pentas Seni Akhir Tahun',
            'excerpt' => 'Pementasan bersama seluruh anak didik sanggar sebagai penutup tahun latihan.',
            'body' => '<p>Contoh kegiatan. Ubah atau hapus melalui menu Kegiatan di dashboard.</p>',
            'location' => 'Wantilan Desa',
            'starts_at' => now()->endOfYear()->subDays(3)->setTime(18, 30),
            'status' => $published,
        ]);
    }
}
