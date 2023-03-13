<?php

namespace Database\Seeders;

use App\Models\Settings\Advantage;
use Illuminate\Database\Seeder;

class AdvantageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advantage::create([
            'setting_id' => 1,
            'num' => 1,
            'title' => 'Venice Pizzeria uses fresh, high-quality ingredients to create delicious, flavorful pizzas.',
            'url' => 'homepage/setting/advantage-1.svg'
        ]);
        Advantage::create([
            'setting_id' => 1,
            'num' => 2,
            'title' => 'Our pizza makers who take pride in their craft and pay attention to every detail in the preparation of their pizzas.',
            'url' => 'homepage/setting/advantage-2.svg'
        ]);
        Advantage::create([
            'setting_id' => 1,
            'num' => 3,
            'title' => ' Our pizzeria offers a variety of options to cater to different tastes and dietary restrictions, including gluten-free, vegetarian, and meat-lovers options',
            'url' => 'homepage/setting/advantage-3.svg'
        ]);
    }
}
