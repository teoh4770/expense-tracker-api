<?php

namespace Database\Factories;

use App\Enums\ExpenseType;
use App\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(
                nbMaxDecimals: 2,
                max: 100
            ),
            'type' => $this->faker->randomElement(
                ExpenseType::cases()
            )
        ];
    }
}
