<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car; // ✅ REQUIRED
use App\Models\CarImage; // ✅ Optional (cleaner)

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Car::factory()
            ->count(5)
            ->has(CarImage::factory()->count(5), 'images')
            ->create();
    }
}
