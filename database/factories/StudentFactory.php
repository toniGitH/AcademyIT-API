<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name_1' => $this->faker->lastName(),
            'last_name_2' => $this->faker->optional()->lastName(),
            'age' => $this->faker->numberBetween(18, 30),
        ];
    }
}
