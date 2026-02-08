<?php

namespace Database\Factories;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarImages>
 */
class CarImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        protected $model = CarImage::class;

    public function definition()
    {
        return [
            'car_id' => Car::inRandomOrder()->first()->id,
            'image_path' => $this->faker->imageUrl(800, 600, 'cars'),
            'position' => (string) $this->faker->numberBetween(1, 5),
        ];
    }
}
