<?php

namespace App\Models;

use App\Models\Concerns\DeletesReplacedFiles;
use App\Models\Concerns\HasPublishStatus;
use App\Models\Concerns\HasSlug;
use Database\Factories\ArtworkFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'artist_id', 'title', 'slug', 'category', 'year', 'excerpt',
    'description', 'image', 'video_url', 'is_featured', 'status',
])]
class Artwork extends Model
{
    /** @use HasFactory<ArtworkFactory> */
    use DeletesReplacedFiles, HasFactory, HasPublishStatus, HasSlug;

    /** Kategori karya seni yang tersedia. */
    public const CATEGORIES = [
        'tari' => 'Tari',
        'tabuh' => 'Tabuh / Gamelan',
        'vokal' => 'Vokal / Tembang',
        'drama' => 'Drama / Sendratari',
        'rupa' => 'Seni Rupa',
        'kriya' => 'Kriya',
    ];

    /** @var list<string> */
    protected array $fileAttributes = ['image'];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category);
    }

    /**
     * URL embed YouTube (bila video_url adalah tautan YouTube).
     */
    public function youtubeEmbedUrl(): ?string
    {
        if (blank($this->video_url)) {
            return null;
        }

        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $this->video_url, $matches);

        return isset($matches[1]) ? "https://www.youtube-nocookie.com/embed/{$matches[1]}" : null;
    }
}
