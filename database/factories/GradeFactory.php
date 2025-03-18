<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    protected $model = Grade::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(), 
            'subject_id' => Subject::factory(),
            'grade' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
