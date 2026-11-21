<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\GalleryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryItem>
 */
class GalleryItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'image' => 'gallery/'.fake()->uuid().'.jpg',
            'status' => ContentStatus::Published,
        ];
    }
}
