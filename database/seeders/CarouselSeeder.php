<?php

namespace Database\Seeders;

use App\Models\Carousel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carousel::create([
            'title' => "Pepperoni Lover Pizza For Collection",
            'image' => "products/product-1.png",
            'price' => 7.99,
        ]);
        Carousel::create([
            'title' => "Sausage and Pepperoni Pizza For Collection",
            'image' => "products/product-1.png",
            'price' => 7.99,
        ]);
        Carousel::create([
            'title' => "Veggie Lover Pizza For Collection",
            'image' => "products/product-1.png",
            'price' => 7.99,
        ]);
    }
}
