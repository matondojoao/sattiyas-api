<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => $this->faker->randomFloat(2, 1, 10),
            'price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
