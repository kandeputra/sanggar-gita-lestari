<?php

namespace Database\Seeders;

use App\Models\SanggarProfile;
use App\Services\SanggarProfileService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SanggarProfileSeeder extends Seeder
{
    public function run(SanggarProfileService $profiles): void
    {
        if (SanggarProfile::query()->exists()) {
            return;
        }

        SanggarProfile::query()->create([
            'name' => 'Sanggar Gita Lestari',
            'tagline' => 'Melestarikan Seni Budaya Bali',
            'short_description' => 'Sanggar seni tari dan tabuh Bali yang menjadi rumah belajar bagi anak-anak, remaja, dan masyarakat untuk mengenal, mencintai, dan melestarikan seni budaya Bali.',
            'history' => '<p>Sanggar Gita Lestari lahir dari kecintaan terhadap seni tari dan tabuh Bali. Berawal dari latihan sederhana di halaman rumah, sanggar terus tumbuh menjadi wadah pembinaan generasi muda.</p><p>Silakan perbarui sejarah lengkap sanggar melalui dashboard admin pada menu <strong>Profil Sanggar</strong>.</p>',
            'vision' => 'Menjadi sanggar seni yang melahirkan generasi berkarakter, berbudaya, dan bangga akan warisan seni Bali.',
            'mission' => "Menyelenggarakan pelatihan tari dan tabuh Bali yang terstruktur.\nMenanamkan nilai budaya, disiplin, dan kebersamaan kepada anak didik.\nAktif ngayah dan berpentas dalam kegiatan adat maupun festival seni.\nMendokumentasikan dan memperkenalkan karya seni Bali kepada masyarakat luas.",
            'script_image' => $this->copyAsset('aksara-gita-lestari.png'),
            'leader_name' => 'Nama Pimpinan Sanggar',
            'leader_title' => 'Pendiri & Pembina Sanggar',
            'leader_photo' => $this->copyAsset('pimpinan-sanggar.jpg'),
            'leader_message' => 'Om Swastyastu. Sanggar ini adalah rumah bagi siapa saja yang ingin belajar dan merawat seni Bali. Mari bersama-sama menjaga warisan leluhur agar tetap lestari untuk generasi mendatang.',
            'address' => 'Bali, Indonesia',
        ]);

        $profiles->forget();
    }

    private function copyAsset(string $filename): ?string
    {
        $source = database_path("seeders/assets/{$filename}");

        if (! is_file($source)) {
            return null;
        }

        $path = "profile/{$filename}";
        Storage::disk('public')->put($path, file_get_contents($source));

        return $path;
    }
}
