<?php

namespace Database\Factories;

use App\Models\DeliveryOption;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            'delivery_option_id' => DeliveryOption::inRandomOrder()->first()->id,
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'fulfillment_status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'canceled']),
        ];
    }
}
