<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     */
    protected $model = User::class;
    public function definition()
    {return [
    'first_name' => fake()->firstName(),
    'last_name' => fake()->lastName(),
    'email' => fake()->unique()->safeEmail(),
    'phone' => fake()->unique()->numerify('###-###-####'),
    'role' => \App\Models\User::ROLE_ADMIN, // force admin role if needed
    'email_verified_at' => now(),
    'password' => bcrypt('Admin@123'), // new password
    'remember_token' => Str::random(10),
];

    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
