<?php

namespace Database\Seeders;

use App\Models\ScheduledClass;
use Illuminate\Database\Seeder;

class ScheduledClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScheduledClass::factory()->count(20)->create();
    }
}
