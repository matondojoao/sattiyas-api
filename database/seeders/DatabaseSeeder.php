<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Category::factory()->count(10)->create();
        \App\Models\Brand::factory()->count(10)->create();

        $this->call([
            SizeSeeder::class,
            ColorSeeder::class
        ]);

        $countries= \App\Models\Country::factory(1)->create();

        foreach($countries as $country){
            $country->states()->saveMany(\App\Models\State::factory()->count(2)->make());
        }

        $states = \App\Models\State::all();

        foreach ($states as $state) {
            $state->cities()->saveMany(\App\Models\City::factory()->count(5)->make());
        }

        \App\Models\User::factory(10)->create();

        \App\Models\BillingAddress::factory()->count(5)->create();
        \App\Models\ShippingAddress::factory()->count(5)->create();

        \App\Models\Product::factory()->count(40)->create();

        \App\Models\ProductImage::factory()->count(60)->create();

        \App\Models\ProductCategory::factory()->count(19)->create();

        \App\Models\ProductColor::factory()->count(19)->create();

        \App\Models\ProductSize::factory()->count(15)->create();

        \App\Models\Promotion::factory()->count(5)->create();

        \App\Models\PaymentMethod::factory()->count(3)->create();

        \App\Models\DeliveryOption::factory()->count(3)->create();

        // \App\Models\Order::factory()->count(5)->create();

        // \App\Models\OrderItem::factory()->count(15)->create();

        \App\Models\Stock::factory()->count(15)->create();

        \App\Models\Review::factory()->count(20)->create();

        \App\Models\Wishlist::factory()->count(9)->create();
    }
}
