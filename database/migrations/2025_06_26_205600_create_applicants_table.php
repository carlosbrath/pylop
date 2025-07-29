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
            $table->string('phone');

            $table->string('businessName');
            $table->enum('businessType', ['New', 'Running']);
            $table->enum('quota', ['Men', 'Women', 'Disabled', 'Transgender']);

            $table->text('businessAddress');
            $table->text('permanentAddress');

            $table->bigInteger('business_category_id')->nullable();
            $table->bigInteger('business_sub_category_id')->nullable();
            
            $table->unsignedTinyInteger('tier'); 
            $table->bigInteger('amount')->nullable();


            $table->bigInteger('district_id')->nullable();
            $table->bigInteger('tehsil_id')->nullable();

           $table->bigInteger('applicant_choosed_branch')->nullable();
          
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('challan_branch_id')->nullable();
            $table->bigInteger('challan_fee')->nullable();
            $table->string('challan_image')->nullable();

            $table->string('cnic_front')->nullable();
            $table->string('cnic_back')->nullable();
            
            $table->enum('fee_status', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('status', ['NotCompleted','Pending', 'Forwarded', 'Approved', 'Rejected'])->default('Pending');

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
