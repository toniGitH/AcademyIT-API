<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [];
        $subjectNames = ['Matemáticas', 'Lengua Española', 'Historia', 'Física', 'Biología'];
        $courseLevels = ['1r', '2n', '3r', '4t'];

        foreach ($subjectNames as $subject) {
            foreach ($courseLevels as $level) {
                $subjects[] = ['name' => $subject, 'course_level' => $level];
            }
        }

        DB::table('subjects')->insert($subjects);
    }
}
