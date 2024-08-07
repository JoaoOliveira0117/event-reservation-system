<?php

namespace Database\Factories;

use App\Enums\EventStatus;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(8),
            'deadline' => $this->faker->date(),
            'date' => $this->faker->dateTime(),
            'location' => $this->faker->address(),
            'price' => $this->faker->randomFloat(2,0,99),
            'attendee_limit' => $this->faker->randomNumber(2),
            'status' => $this->faker->randomElement(array_map(fn($case) => $case->value, EventStatus::cases()))
        ];
    }
}
