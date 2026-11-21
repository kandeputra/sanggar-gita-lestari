<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Artist>
 */
class ArtistFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'specialty' => fake()->randomElement(['Penari', 'Penabuh', 'Pelatih Tari']),
            'bio' => fake()->paragraph(),
            'sort_order' => fake()->numberBetween(0, 20),
            'status' => ContentStatus::Published,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => ['status' => ContentStatus::Draft]);
    }
}
