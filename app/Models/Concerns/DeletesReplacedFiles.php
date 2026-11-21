<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

/**
 * Menghapus file gambar lama dari Laravel Storage (disk "public")
 * ketika gambar diganti atau record dihapus, agar storage hosting tetap bersih.
 *
 * Model wajib mendefinisikan: protected array $fileAttributes = ['image'];
 */
trait DeletesReplacedFiles
{
    public static function bootDeletesReplacedFiles(): void
    {
        static::updated(function (self $model): void {
            foreach ($model->fileAttributes as $attribute) {
                if ($model->wasChanged($attribute)) {
                    $model->deleteStoredFile($model->getOriginal($attribute));
                }
            }
        });

        static::deleted(function (self $model): void {
            foreach ($model->fileAttributes as $attribute) {
                $model->deleteStoredFile($model->getAttribute($attribute));
            }
        });
    }

    protected function deleteStoredFile(?string $path): void
    {
        if (filled($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function fileUrl(string $attribute): ?string
    {
        $path = $this->getAttribute($attribute);

        return filled($path) ? Storage::disk('public')->url($path) : null;
    }
}
