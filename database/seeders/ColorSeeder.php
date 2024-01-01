<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cores = [
            ['name' => 'Vermelho', 'class' => 'cs_accent_bg'],
            ['name' => 'Cinza', 'class' => 'cs_secondary_bg'],
            ['name' => 'Preto', 'class' => 'cs_primary_bg'],
            ['name' => 'Branco', 'class' => 'cs_white_bg'],
        ];

        foreach ($cores as $cor) {
            Color::create($cor);
        }
    }
}
