<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Pizza',
            'url' => 'homepage/categories/pizza.svg'
        ]);
        Category::create([
            'name' => 'Lasagna',
            'url' => 'homepage/categories/lasagna.png'
        ]);
        Category::create([
            'name' => 'Make it better',
            'url' => 'homepage/categories/pizza.svg'
        ]);
        Category::create([
            'name' => 'Salad',
            'url' => 'homepage/categories/vegetarian.svg'
        ]);
        Category::create([
            'name' => 'Sauce',
            'url' => 'homepage/categories/sous.png'
        ]);
        Category::create([
            'name' => 'Drink',
            'url' => 'homepage/categories/drink.png'
        ]);

    }
}
