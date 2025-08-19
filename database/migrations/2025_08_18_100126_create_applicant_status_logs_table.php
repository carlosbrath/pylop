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
        Schema::create('applicant_status_logs', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('applicant_id');
            $table->enum('old_status', ['NotCompleted','Pending','Forwarded','Approved','Rejected'])->nullable();
            $table->enum('new_status', ['NotCompleted','Pending','Forwarded','Approved','Rejected']);
            $table->string('changed_by_type', 50)->nullable(); 
            $table->unsignedBigInteger('changed_by_id')->nullable();
            $table->longText('remarks')->nullable(); 
            $table->timestamps();

            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_status_logs');
    }
};
