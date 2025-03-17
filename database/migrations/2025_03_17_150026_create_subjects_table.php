<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('course_level', ['1r', '2n', '3r', '4t']);
            $table->timestamps();
            // Restriction to avoid having duplicate subject-course assignments
            $table->unique(['name', 'course_level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
}
