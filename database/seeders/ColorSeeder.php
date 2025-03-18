<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{

    public function run(): void
    {
        $colors = [
            ['name' => 'Black', 'code' => '#000000'],
            ['name' => 'Blue', 'code' => '#007bff'],
            ['name' => 'Brown', 'code' => '#8B4513'],
            ['name' => 'Burgundy', 'code' => '#800020'],
            ['name' => 'Gold', 'code' => '#FFD700'],
            ['name' => 'Grey', 'code' => '#808080'],
            ['name' => 'Orange', 'code' => '#FFA500'],
            ['name' => 'Green', 'code' => '#008000'],
            ['name' => 'Purple', 'code' => '#800080'],
            ['name' => 'Red', 'code' => '#FF0000'],
            ['name' => 'Silver', 'code' => '#C0C0C0'],
            ['name' => 'Beige', 'code' => '#F5F5DC'],
            ['name' => 'Tan', 'code' => '#D2B48C'],
            ['name' => 'Teal', 'code' => '#008080'],
            ['name' => 'White', 'code' => '#FFFFFF'],
            ['name' => 'Yellow', 'code' => '#FFFF00'],
        ];

        foreach ($colors as $index => $color) {
            DB::table('colors')->insert([
                'name'       => $color['name'],
                'code'       => $color['code'],
                'uid'        => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
