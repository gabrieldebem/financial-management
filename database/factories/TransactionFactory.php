<?php

namespace Database\Factories;

use App\Enums\Direction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = \App\Models\Transaction::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'amount' => $this->faker->numberBetween(100, 10000),
            'direction' => $this->faker->randomElement(Direction::cases()),
            'description' => $this->faker->sentence,
        ];
    }
}
