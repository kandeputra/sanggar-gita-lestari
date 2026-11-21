<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Artwork;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Artwork>
 */
class ArtworkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'Tari '.fake()->unique()->word(),
            'category' => fake()->randomElement(array_keys(Artwork::CATEGORIES)),
            'year' => fake()->numberBetween(1990, 2026),
            'excerpt' => fake()->sentence(),
            'description' => '<p>'.fake()->paragraph().'</p>',
            'status' => ContentStatus::Published,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => ['status' => ContentStatus::Draft]);
    }
}
