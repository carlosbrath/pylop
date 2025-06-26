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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('fatherName');
            $table->string('cnic')->unique();
            $table->date('cnic_issue_date');
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('phone');

            $table->string('businessName');
            $table->enum('businessType', ['New', 'Running']);

            $table->string('district');
            $table->enum('quota', ['Men', 'Women', 'Disabled', 'Transgender']);

            $table->text('PermanentAddress');
            $table->text('CurrentAddress');

            $table->unsignedTinyInteger('tier'); // 1, 2, or 3
            $table->enum('status', ['NotCompleted','Pending', 'Approved', 'Rejected'])->default('Pending');

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
        Schema::dropIfExists('applicants');
    }
};
