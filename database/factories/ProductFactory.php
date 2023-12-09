<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'body' => $this->faker->text,
            'regular_price' => $this->faker->randomFloat(2, 10, 100),
            'sale_price' => $this->faker->optional(0.3, null)->randomFloat(2, 5, 50),
            'shipping_type' => $this->faker->word,
            'delivery' => $this->faker->word,
            'product_id_type' => $this->faker->word,
            'product_id' => $this->faker->word,
            'expiry_date_of_product' => $this->faker->date,
            'sku' => $this->faker->word,
            'is_featured' => $this->faker->boolean,
            'manufacturer' => $this->faker->word,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
