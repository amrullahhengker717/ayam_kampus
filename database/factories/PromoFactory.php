<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Promo>
 */
class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'title' => fake()->words(2, true) . ' Promo',
            'discount_percentage' => fake()->randomElement([10, 15, 20, 50]),
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDays(5),
        ];
    }
}
