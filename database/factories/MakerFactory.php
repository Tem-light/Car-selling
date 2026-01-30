<?php

namespace Database\Factories;
use App\Models\Maker;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MakerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Maker::class;

    public function definition()
    {
          return [
            'name' => $this->faker->word(),
        ];
    }
}
