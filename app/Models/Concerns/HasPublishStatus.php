<?php

namespace App\Models\Concerns;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

/**
 * Status publikasi bersama untuk seluruh konten CMS.
 * Website publik hanya boleh menampilkan konten berstatus "published".
 */
trait HasPublishStatus
{
    public function initializeHasPublishStatus(): void
    {
        $this->mergeCasts(['status' => ContentStatus::class]);
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where($this->qualifyColumn('status'), ContentStatus::Published);
    }

    public function isPublished(): bool
    {
        return $this->status === ContentStatus::Published;
    }
}
