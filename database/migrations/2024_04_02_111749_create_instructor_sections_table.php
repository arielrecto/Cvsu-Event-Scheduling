<?php

use App\Models\InstructorInfo;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instructor_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InstructorInfo::class);
            $table->foreignIdFor(Section::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_sections');
    }
};
