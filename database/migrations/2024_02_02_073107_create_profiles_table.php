<?php

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('student_id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('age');
            $table->string('gender');
            $table->longText('address');
            $table->foreignIdFor(Section::class);
            $table->foreignIdFor(Course::class);
            $table->string('valid_documents')->nullable();
            $table->string('verified_at')->nullable();
            $table->foreignIdFor(User::class)->constrained()->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
