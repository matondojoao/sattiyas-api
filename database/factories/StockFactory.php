<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product = Product::factory()->create();

        return [
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(0, 100),
            'alert_threshold' => $this->faker->optional(0.5, null)->numberBetween(1, 20),
        ];
    }
}
