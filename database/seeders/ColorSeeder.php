<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'Strong Red-Orange','hex_code' => '#f54a00'],
            ['name' => 'Red',       'hex_code' => '#FF0000'],
            ['name' => 'Green',     'hex_code' => '#00FF00'],
            ['name' => 'Blue',      'hex_code' => '#0000FF'],
            ['name' => 'Yellow',    'hex_code' => '#FFFF00'],
            ['name' => 'Black',     'hex_code' => '#000000'],
            ['name' => 'White',     'hex_code' => '#FFFFFF'],
            ['name' => 'Gray',      'hex_code' => '#808080'],
            ['name' => 'Orange',    'hex_code' => '#FFA500'],
            ['name' => 'Purple',    'hex_code' => '#800080'],
            ['name' => 'Cyan',      'hex_code' => '#00FFFF'],
            ['name' => 'Magenta',   'hex_code' => '#FF00FF'],
            ['name' => 'Brown',     'hex_code' => '#A52A2A'],
            ['name' => 'Pink',      'hex_code' => '#FFC0CB'],
            ['name' => 'Teal',      'hex_code' => '#008080'],
            ['name' => 'Indigo',    'hex_code' => '#4B0082'],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate(['hex_code' => $color['hex_code']], $color);
        }
    }
}
