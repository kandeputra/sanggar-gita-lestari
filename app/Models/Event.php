<?php

namespace App\Models;

use App\Models\Concerns\DeletesReplacedFiles;
use App\Models\Concerns\HasPublishStatus;
use App\Models\Concerns\HasSlug;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug', 'excerpt', 'body', 'image', 'location', 'starts_at', 'ends_at', 'status'])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use DeletesReplacedFiles, HasFactory, HasPublishStatus, HasSlug;

    /** @var list<string> */
    protected array $fileAttributes = ['image'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function galleryItems(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }

    #[Scope]
    protected function upcoming(Builder $query): void
    {
        $query->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at');
    }

    #[Scope]
    protected function past(Builder $query): void
    {
        $query->where('starts_at', '<', now()->startOfDay())->orderByDesc('starts_at');
    }

    public function isUpcoming(): bool
    {
        return $this->starts_at->isAfter(now()->startOfDay());
    }
}
