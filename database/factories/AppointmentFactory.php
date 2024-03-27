<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'calendar_id' => \App\Models\Calendar::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'color' => $this->faker->hexColor,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
