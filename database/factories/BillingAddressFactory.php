<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillingAddress>
 */
class BillingAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'address'=>$this->faker->streetAddress(),
            'number'=>$this->faker->buildingNumber(),
            'neighborhood'=>$this->faker->citySuffix(),
            'complement'=>$this->faker->secondaryAddress(),
            'zip_code'=>$this->faker->postcode(),
            'city_id' => City::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
