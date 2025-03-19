<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['first_name' => 'Carlos', 'last_name_1' => 'García', 'last_name_2' => 'Fernández', 'age' => 18],
            ['first_name' => 'María', 'last_name_1' => 'López', 'last_name_2' => 'Martínez', 'age' => 19],
            ['first_name' => 'Javier', 'last_name_1' => 'Pérez', 'last_name_2' => null, 'age' => 20],
            ['first_name' => 'Ana', 'last_name_1' => 'Sánchez', 'last_name_2' => 'Gómez', 'age' => 21],
            ['first_name' => 'Luis', 'last_name_1' => 'Martín', 'last_name_2' => 'Rodríguez', 'age' => 22],
            ['first_name' => 'Elena', 'last_name_1' => 'Díaz', 'last_name_2' => 'Ruiz', 'age' => 23],
            ['first_name' => 'Pedro', 'last_name_1' => 'Hernández', 'last_name_2' => null, 'age' => 24],
            ['first_name' => 'Sofía', 'last_name_1' => 'Torres', 'last_name_2' => 'Vázquez', 'age' => 25],
            ['first_name' => 'Andrés', 'last_name_1' => 'Jiménez', 'last_name_2' => 'Moreno', 'age' => 26],
            ['first_name' => 'Isabel', 'last_name_1' => 'Gutiérrez', 'last_name_2' => null, 'age' => 27],
        ];

        DB::table('students')->insert($students);
    }
}
