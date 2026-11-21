<?php

namespace App\Models;

use App\Models\Concerns\DeletesReplacedFiles;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'tagline', 'short_description', 'history', 'vision', 'mission', 'founded_year',
    'logo', 'script_image', 'hero_image', 'leader_name', 'leader_title', 'leader_photo', 'leader_message',
    'address', 'phone', 'whatsapp', 'email', 'maps_embed_url',
    'instagram_url', 'facebook_url', 'youtube_url', 'tiktok_url', 'meta_description',
])]
class SanggarProfile extends Model
{
    use DeletesReplacedFiles;

    /** @var list<string> */
    protected array $fileAttributes = ['logo', 'script_image', 'hero_image', 'leader_photo'];

    /**
     * Kolom yang termasuk "Profil Sanggar" (konten).
     *
     * @var list<string>
     */
    public const PROFILE_FIELDS = [
        'name', 'tagline', 'short_description', 'history', 'vision', 'mission', 'founded_year',
        'logo', 'script_image', 'hero_image', 'leader_name', 'leader_title', 'leader_photo', 'leader_message',
    ];

    /**
     * Kolom yang termasuk "Pengaturan Situs" (khusus Super Admin).
     *
     * @var list<string>
     */
    public const SETTING_FIELDS = [
        'address', 'phone', 'whatsapp', 'email', 'maps_embed_url',
        'instagram_url', 'facebook_url', 'youtube_url', 'tiktok_url', 'meta_description',
    ];

    public function whatsappLink(): ?string
    {
        if (blank($this->whatsapp)) {
            return null;
        }

        $number = preg_replace('/\D+/', '', $this->whatsapp);

        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        return "https://wa.me/{$number}";
    }

    /**
     * @return array<string, string>
     */
    public function socialLinks(): array
    {
        return array_filter([
            'Instagram' => $this->instagram_url,
            'Facebook' => $this->facebook_url,
            'YouTube' => $this->youtube_url,
            'TikTok' => $this->tiktok_url,
        ]);
    }
}
