<?php

namespace Database\Seeders;

use App\Models\Special;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Special::create([
           'price' => 12,
            'title' => 'The Japanese Oishii Burger',
            'small_title' => 'this month\'s special',
            'image' => 'homepage/specials/burger-1.png'
        ]);
        Special::create([
            'price' => 12,
            'title' => 'Burger With Benefits',
            'small_title' => 'festive special',
            'image' => 'homepage/specials/burger-2.png'
        ]);
        Special::create([
        'price' => 12,
        'title' => 'Fatboy Combo',
        'image' => 'homepage/specials/burger-3.png'
    ]);
        Special::create([
        'price' => 2,
        'title' => 'ALL DAY ERERY DAY',
        'image' => 'Image Soon...'
    ]);
        Special::create([
        'image' => 'homepage/specials/burger-4.png'
    ]);
    }
}
