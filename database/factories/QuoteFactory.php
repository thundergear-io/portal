<?php

namespace Database\Factories;

use App\Enums\QuoteStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 day', '+1 month');
        $endDate = (clone $startDate)->modify('+'. $this->faker->numberBetween(14, 60) .' days');

        return [
            'public_id' => $this->faker->uuid(),
            'title' => $this->faker->sentence(4),
            'client_name' => $this->faker->name(),
            'client_email' => $this->faker->safeEmail(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'brief' => $this->faker->paragraph(4),
            'timeline' => $this->faker->paragraph(2),
            'terms' => $this->faker->paragraph(3),
            'cost_items' => [
                ['description' => 'Discovery & Research', 'amount' => $this->faker->numberBetween(1500, 3500)],
                ['description' => 'Design & UX', 'amount' => $this->faker->numberBetween(2500, 5500)],
                ['description' => 'Implementation', 'amount' => $this->faker->numberBetween(3500, 6500)],
            ],
            'status' => QuoteStatus::Pending,
        ];
    }
}
