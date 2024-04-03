<?php

use App\Models\Course;
use App\Models\InstructorInfo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instructor_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class);
            $table->foreignIdFor(InstructorInfo::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_courses');
    }
};
