<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // existing admin or new
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'role' => User::ROLE_ADMIN,
                'password' => bcrypt('Admin@123')
            ]
        );
    }
}
