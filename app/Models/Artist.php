<?php

namespace App\Models;

use App\Models\Concerns\DeletesReplacedFiles;
use App\Models\Concerns\HasPublishStatus;
use App\Models\Concerns\HasSlug;
use Database\Factories\ArtistFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'specialty', 'bio', 'photo', 'sort_order', 'status'])]
class Artist extends Model
{
    /** @use HasFactory<ArtistFactory> */
    use DeletesReplacedFiles, HasFactory, HasPublishStatus, HasSlug;

    /** @var list<string> */
    protected array $fileAttributes = ['photo'];

    protected function slugSource(): string
    {
        return 'name';
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}
