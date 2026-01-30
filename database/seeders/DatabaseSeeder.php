<?php

namespace Database\Seeders;

use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\CarModel;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -----------------------------
        // Car Types
        // -----------------------------
        CarType::factory()->sequence(
            ['name' => 'Sedan'],
            ['name' => 'SUV'],
            ['name' => 'Hatchback'],
            ['name' => 'Convertible'],
            ['name' => 'Coupe'],
            ['name' => 'Wagon'],
            ['name' => 'Van'],
            ['name' => 'Truck']
        )->count(8)->create();

        // -----------------------------
        // Fuel Types
        // -----------------------------
        FuelType::factory()->sequence(
            ['name' => 'Petrol'],
            ['name' => 'Diesel'],
            ['name' => 'Electric'],
            ['name' => 'Hybrid']
        )->count(4)->create();

        // -----------------------------
        // States and Cities
        // -----------------------------
        $states = [
            "California" => ["Los Angeles", "San Francisco", "San Diego", "Sacramento", "San Jose"],
            "Arizona" => ["Phoenix", "Tucson", "Mesa", "Chandler", "Scottsdale"],
            "New Jersey" => ["Newark", "Jersey City", "Paterson", "Elizabeth", "Edison"],
            "Indiana" => ["Indianapolis", "Fort Wayne", "Evansville", "South Bend", "Carmel"],
            "Minnesota" => ["Minneapolis", "Saint Paul", "Rochester", "Duluth", "Bloomington"],
            "Oregon" => ["Portland", "Salem", "Eugene", "Gresham", "Hillsboro"],
            "Arkansas" => ["Little Rock", "Fort Smith", "Fayetteville", "Springdale", "Jonesboro"],
            "Nebraska" => ["Omaha", "Lincoln", "Bellevue", "Grand Island", "Kearney"],
            "New Hampshire" => ["Manchester", "Nashua", "Concord", "Dover", "Rochester"],
            "North Dakota" => ["Fargo", "Bismarck", "Grand Forks", "Minot", "West Fargo"]
        ];

        foreach ($states as $stateName => $cities) {
            $stateModel = State::factory()->create(['name' => $stateName]);

            foreach ($cities as $cityName) {
                City::factory()->create([
                    'name' => $cityName,
                    'state_id' => $stateModel->id
                ]);
            }
        }

        // -----------------------------
        // Makers and Car Models
        // -----------------------------
        $makers = [
            'Toyota' => ['Camry', 'Corolla', 'Prius'],
            'Ford' => ['F-150', 'Mustang', 'Explorer'],
            'Chevrolet' => ['Silverado', 'Equinox', 'Malibu'],
            'Honda' => ['Civic', 'Accord', 'CR-V'],
            'Nissan' => ['Altima', 'Rogue', 'Sentra'],
            'BMW' => ['X3', 'X5', '3 Series'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'GLC'],
            'Volkswagen' => ['Jetta', 'Golf', 'Passat'],
            'Audi' => ['A4', 'A6', 'Q5'],
            'Hyundai' => ['Elantra', 'Tucson', 'Santa Fe']
        ];

        foreach ($makers as $makerName => $models) {
            $maker = Maker::factory()->create(['name' => $makerName]);

            foreach ($models as $modelName) {
                CarModel::factory()->create([
                    'name' => $modelName,
                    'maker_id' => $maker->id,
                ]);
            }
        }

        // -----------------------------
        // Users
        // -----------------------------
        // Basic users
        User::factory()->count(3)->create();

        // Users with Cars, Features, and Images
    User::factory()
    ->count(3)
    ->has(
        Car::factory()
            ->count(5)
            ->has(
                CarImage::factory()
                    ->count(5)
                    ->sequence(fn (Sequence $sequence) => [
                        'position' => $sequence->index + 1
                    ]),
                'images' // ✅ MUST MATCH Car::images()
            )
            ->hasFeatures(1),
        'cars' // ✅ MUST MATCH User::cars()
    )
    ->create();


    }
}
