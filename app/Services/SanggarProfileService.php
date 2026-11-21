<?php

namespace App\Services;

use App\Models\SanggarProfile;
use Illuminate\Support\Facades\Cache;

/**
 * Satu-satunya pintu untuk membaca & memperbarui Profil Sanggar (single record).
 * Profil di-cache karena dipakai di setiap halaman publik (header, footer, SEO).
 */
class SanggarProfileService
{
    private const CACHE_KEY = 'sanggar_profile';

    public function get(): SanggarProfile
    {
        // Yang di-cache hanya array atribut mentah (bukan objek), karena Laravel 13
        // secara default menolak unserialize class dari cache (cache.serializable_classes).
        $attributes = Cache::rememberForever(
            self::CACHE_KEY,
            fn (): array => $this->record()->getAttributes(),
        );

        return (new SanggarProfile)->newFromBuilder($attributes);
    }

    /**
     * Ambil record langsung dari database (tanpa cache), buat default bila belum ada.
     */
    public function record(): SanggarProfile
    {
        return SanggarProfile::query()->firstOrCreate([], [
            'name' => config('app.name', 'Sanggar Gita Lestari'),
        ]);
    }

    /**
     * Perbarui hanya kolom yang diizinkan, lalu bersihkan cache.
     *
     * @param  array<string, mixed>  $data
     * @param  list<string>  $allowedFields
     */
    public function update(array $data, array $allowedFields): SanggarProfile
    {
        $profile = $this->record();
        $profile->fill(array_intersect_key($data, array_flip($allowedFields)))->save();

        $this->forget();

        return $profile;
    }

    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
