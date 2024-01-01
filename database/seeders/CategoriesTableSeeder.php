<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => '315901a9-0c56-4281-8778-1ed88f9667d2',
                'name' => 'Calças Jeans',
                'slug' => 'calcas-jeans-2',
                'parent_id' => '9a4fbeaa-930c-4fe8-81a1-25f4b37412c0',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:28:33',
                'updated_at' => '2023-12-28 15:28:33',
            ],
            [
                'id' => '72a781d2-bb69-45c6-9377-5fe333acd180',
                'name' => 'Calças Jeans',
                'slug' => 'calcas-jeans-1',
                'parent_id' => '7e0c6746-2075-4cf6-800a-91825a691ae9',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:26:21',
                'updated_at' => '2023-12-28 15:26:21',
            ],
            [
                'id' => '783467b2-0832-4c6d-8b52-beb28ca9067a',
                'name' => 'Calças Jeans',
                'slug' => 'calcas-jeans',
                'parent_id' => 'db0d3b8c-d3a0-48a1-a8c5-2ec77eb5b4f9',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:23:25',
                'updated_at' => '2023-12-28 15:23:25',
            ],
            [
                'id' => '7e0c6746-2075-4cf6-800a-91825a691ae9',
                'name' => 'Homens',
                'slug' => 'homens',
                'parent_id' => NULL,
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:24:46',
                'updated_at' => '2023-12-28 15:24:46',
            ],
            [
                'id' => '9a4fbeaa-930c-4fe8-81a1-25f4b37412c0',
                'name' => 'Crianças',
                'slug' => 'criancas',
                'parent_id' => NULL,
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:27:24',
                'updated_at' => '2023-12-28 15:27:24',
            ],
            [
                'id' => 'aafe6875-cf08-4e89-ad7d-333450b332e0',
                'name' => 'Camisas',
                'slug' => 'camisas',
                'parent_id' => '9a4fbeaa-930c-4fe8-81a1-25f4b37412c0',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:28:14',
                'updated_at' => '2023-12-28 15:28:14',
            ],
            [
                'id' => 'ca561285-2ea3-46d0-a684-1a58ca1caefa',
                'name' => 'Ternos',
                'slug' => 'ternos',
                'parent_id' => '7e0c6746-2075-4cf6-800a-91825a691ae9',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:26:32',
                'updated_at' => '2023-12-28 15:26:32',
            ],
            [
                'id' => 'd816a358-4bd6-44d1-a58f-ce1da783ac00',
                'name' => 'Vestidos',
                'slug' => 'vestidos',
                'parent_id' => 'db0d3b8c-d3a0-48a1-a8c5-2ec77eb5b4f9',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:23:07',
                'updated_at' => '2023-12-28 15:23:07',
            ],
            [
                'id' => 'db0d3b8c-d3a0-48a1-a8c5-2ec77eb5b4f9',
                'name' => 'Mulher',
                'slug' => 'mulher',
                'parent_id' => NULL,
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:21:44',
                'updated_at' => '2023-12-28 15:21:44',
            ],
            [
                'id' => 'e12cb64e-7c7e-4a92-bb2a-7c4d756f0641',
                'name' => 'Calças',
                'slug' => 'calcas',
                'parent_id' => '9a4fbeaa-930c-4fe8-81a1-25f4b37412c0',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:28:24',
                'updated_at' => '2023-12-28 15:28:24',
            ],
            [
                'id' => 'e65c8b75-3841-4cb9-81c3-023e1dd2138b',
                'name' => 'Camiseta',
                'slug' => 'camiseta',
                'parent_id' => '7e0c6746-2075-4cf6-800a-91825a691ae9',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:26:10',
                'updated_at' => '2023-12-28 15:26:10',
            ],
            [
                'id' => 'ef4bdfad-046b-4415-aef4-5f462e0aa040',
                'name' => 'Tops',
                'slug' => 'tops',
                'parent_id' => 'db0d3b8c-d3a0-48a1-a8c5-2ec77eb5b4f9',
                'image_url' => NULL,
                'created_at' => '2023-12-28 15:23:18',
                'updated_at' => '2023-12-28 15:23:18',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }
    }
}
