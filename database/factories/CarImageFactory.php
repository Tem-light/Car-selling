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
            'image_path' => $this->faker->imageUrl(),
            'position' => function(array $attributes) {
                return Car::find($attributes['car_id'])->images()->count() + 1;
            },
        ];
    }
}
