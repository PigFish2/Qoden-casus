<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->randomId(),
            'name' => $this->faker->name(),
            'date_of_birth' => $this->faker->date(),
            'address' => $this->faker->address(),
        ];
    }

    /**
     * Generates a random 5 digit id and checks if it doesn't exist in the database. 
     * Always returns a new ID, unless all numbers between 10000 and 99999 are taken, then it would be a infinite loop. But for this small project i didn't bother taking it out.
     */
    private function randomId() {
        do {
            $id = $this->faker->numberBetween(10000, 99999); // Generate random ID
        } while (Patient::where('id', $id)->exists());

        return $id;
    }
}
