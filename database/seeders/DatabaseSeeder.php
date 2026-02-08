<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarFeature;
use App\Models\CarImage;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed each table with 5 records using factories.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();
        CarType::factory()->count(5)->create();
        FuelType::factory()->count(5)->create();

        $this->call(MakerModelStateCitySeeder::class);

        Car::factory()->count(5)->create();

        // CarFeature: one per car (car_id is primary key); use updateOrCreate so re-seeding doesn't duplicate
        Car::all()->each(function (Car $car) {
            CarFeature::updateOrCreate(
                ['car_id' => $car->id],
                array_merge(CarFeature::factory()->definition(), ['car_id' => $car->id])
            );
        });

        CarImage::factory()->count(5)->create();
    }
}
