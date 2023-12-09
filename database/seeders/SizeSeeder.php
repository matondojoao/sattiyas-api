<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tamanhos = [
            ['name' => 'P'],
            ['name' => 'M'],
            ['name' => 'G'],
            ['name' => 'GG'],
            ['name' => 'XL'],
        ];

        foreach ($tamanhos as $tamanho) {
            Size::create($tamanho);
        }
    }
}
