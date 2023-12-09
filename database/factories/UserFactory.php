<?php

namespace Database\Factories;

use App\Models\BillingAddress;
use App\Models\ShippingAddress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'photo_path' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => $this->faker->phoneNumber,
            'alternative_phone' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'role' => $this->faker->randomElement(['admin', 'customer']),
            'remember_token' => Str::random(10),
            'shipping_address_id'=>ShippingAddress::inRandomOrder()->first()->id,
            'billing_address_id'=>BillingAddress::inRandomOrder()->first()->id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
