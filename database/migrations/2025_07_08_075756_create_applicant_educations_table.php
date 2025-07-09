<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_id'); // Link to applicant if needed
            $table->string('education_level'); // e.g., Matric, Intermediate, Bachelors
            $table->string('degree_title')->nullable(); // Optional, e.g., BSc, ICS, Diploma in IT
            $table->string('institute')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('grade_or_percentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_educations');
    }
};
