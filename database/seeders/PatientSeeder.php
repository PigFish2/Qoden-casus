<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Container\Attributes\Log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * To run this seeder, use the command: php artisan db:seed --class=PatientSeeder
     */
    public function run(): void
    {
        Patient::factory()->count(5)->create();
    }
}
