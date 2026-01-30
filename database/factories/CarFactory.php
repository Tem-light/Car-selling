<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Maker;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\User;
use App\Models\City;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition()
    {
        // ✅ Select related models ONCE
        $maker = Maker::inRandomOrder()->first();
        $model = CarModel::where('maker_id', $maker->id)->inRandomOrder()->first();
        $user  = User::inRandomOrder()->first();

        return [
            'maker_id' => $maker->id,
            'car_model_id' => $model->id,

            'year' => $this->faker->numberBetween(1990, 2024),
            'price' => $this->faker->numberBetween(500, 50000),
            'vin' => Str::upper(Str::random(17)),
            'mileage' => $this->faker->numberBetween(0, 200000),

            // ✅ correct column name
            'car_type_id' => CarType::inRandomOrder()->first()->id,
            'fuel_type_id' => FuelType::inRandomOrder()->first()->id,

            // ✅ same user reused safely
            'user_id' => $user->id,
            'phone'   => $user->phone,

            'city_id' => City::inRandomOrder()->first()->id,
            'address' => $this->faker->address(),
            'description' => $this->faker->text(200),
            'published_at' => $this->faker->optional(0.9)->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
