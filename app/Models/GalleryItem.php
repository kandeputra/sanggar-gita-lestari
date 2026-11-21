<?php

namespace App\Models;

use App\Models\Concerns\DeletesReplacedFiles;
use App\Models\Concerns\HasPublishStatus;
use Database\Factories\GalleryItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['event_id', 'title', 'image', 'caption', 'sort_order', 'status'])]
class GalleryItem extends Model
{
    /** @use HasFactory<GalleryItemFactory> */
    use DeletesReplacedFiles, HasFactory, HasPublishStatus;

    /** @var list<string> */
    protected array $fileAttributes = ['image'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
