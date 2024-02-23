<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Madhu Sahitya',
            'email' => 'madhu@example.com',
        ]);
        User::factory()->create([
            'name' => 'Kumar Sahitya',
            'email' => 'kumar@example.com',
        ]);
        User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'role' => 'instructor',
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        User::factory()->count(10)->create();
        User::factory()->count(10)->create([
            'role' => 'instructor',
        ]);
    }
}
