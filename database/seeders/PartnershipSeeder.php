<?php

namespace Database\Seeders;

use App\Models\Partnership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partnership::create([
           "first_name" => "Orifjon",
           "last_name" => "Orifov",
           "phone" => "+998908319755",
           "email" => "avazbekoripov94@gmail.com",
           "message" => "Test Partnership Text"
        ]);
    }
}
