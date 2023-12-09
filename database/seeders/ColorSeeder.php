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
            ['name' => 'Vermelho', 'hex_format' => '#FF0000'],
            ['name' => 'Verde', 'hex_format' => '#00FF00'],
            ['name' => 'Azul', 'hex_format' => '#0000FF'],
            ['name' => 'Amarelo', 'hex_format' => '#FFFF00'],
            ['name' => 'Laranja', 'hex_format' => '#FFA500'],
            ['name' => 'Roxo', 'hex_format' => '#800080'],
            ['name' => 'Rosa', 'hex_format' => '#FFC0CB'],
            ['name' => 'Marrom', 'hex_format' => '#A52A2A'],
            ['name' => 'Cinza', 'hex_format' => '#808080'],
            ['name' => 'Preto', 'hex_format' => '#000000'],
        ];

        foreach ($cores as $cor) {
            Color::create($cor);
        }
    }
}
