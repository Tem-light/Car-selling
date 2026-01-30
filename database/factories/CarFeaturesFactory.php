<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarFeatures>
 */
class CarFeaturesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'abs' => $this->faker->boolean(),
            'air_conditioning' => $this->faker->boolean(),
            'power_windows' => $this->faker->boolean(),
            'power_door_lock' => $this->faker->boolean(),
            'cruise_control' => $this->faker->boolean(),
            'bluetooth_connection' => $this->faker->boolean(),
            'remote_start' => $this->faker->boolean(),
            'gps_navigation' => $this->faker->boolean(),
            'heated_seats' => $this->faker->boolean(),
            'climate_control' => $this->faker->boolean(),
            'rear_parking_sensors' => $this->faker->boolean(),
            'leather_seats' => $this->faker->boolean(),
        ];
    }
}
