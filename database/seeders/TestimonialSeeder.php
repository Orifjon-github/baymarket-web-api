<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Testimonial::create([
           'name' => "Naushed Reza",
           'body' => 'Our new favourite place to order pizza from! Can recommend enough!

Very friendly staff, delivery is always on time, and most importantly, amazing pizzas. I would recommend  the Chicken Classic and the Vegetarian pizzas.

Vegetarian options: Vegetarian Pizza',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
        Testimonial::create([
            'name' => "Anca Pertu",
            'body' => 'Friendly staff, fast service and amazing pizza, ordered once and kept coming back. Highly recommend! 💕',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
        Testimonial::create([
            'name' => "Elenora Zeneli",
            'body' => 'Amazing good pizzas for a good price as well! Very friendly too, def recommend!',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
        Testimonial::create([
            'name' => "Edvin",
            'body' => 'Very nice Pizzeria, chef\'s works nice and clean, possible to get any pizza up to you as example I prefer tiny and crispy, so 5 Star ⭐️ ⭐️ ⭐️ ⭐️ ⭐️, recommend.',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
        Testimonial::create([
            'name' => "Andreina Ganata",
            'body' => 'Very fast delivery
Pizzas are very nice! Good quality, amazing taste',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
        Testimonial::create([
            'name' => "MR Randomizer",
            'body' => '5 STAR DEFINITELY! It is a great place and the person who runs it, is very nice! I bought a pizza and it didn’t take very long. This is a pizza place with lots of fizzy drink/chocolate milk choices, ICE CREAM (as I’ve shown in the pictures) and sweets! Lots of sides and pizza. Do not judge this place by how small it is because the taste of the pizza is FANTASTIC.',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
        Testimonial::create([
            'name' => "Hamish Ryall",
            'body' => 'Fantastic service. I ordered a pizza by mistake which had mushroom on it. I am allergic to mushroom. I called them and they sent me a different pizza free of charge. Could not be happier :))',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
        Testimonial::create([
            'name' => "Khakberdiev Akbar",
            'body' => 'Such an amazing pizzas I have ever eat',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
        Testimonial::create([
            'name' => "Z Zaheer ",
            'body' => 'Excellent. Top notch. Quality ingredients and delivered lovely and hot',
            'rating' => 5,
            'image' => 'homepage/users/user-1.png'
        ]);
    }
}
