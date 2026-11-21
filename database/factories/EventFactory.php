<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'Pentas '.fake()->unique()->words(2, true),
            'excerpt' => fake()->sentence(),
            'body' => '<p>'.fake()->paragraph().'</p>',
            'location' => fake()->city(),
            'starts_at' => now()->addDays(fake()->numberBetween(1, 60)),
            'status' => ContentStatus::Published,
        ];
    }

    public function past(): static
    {
        return $this->state(fn (): array => ['starts_at' => now()->subDays(fake()->numberBetween(2, 60))]);
    }

    public function draft(): static
    {
        return $this->state(fn (): array => ['status' => ContentStatus::Draft]);
    }
}
