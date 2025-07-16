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

            $table->string('branch_name')->nullable()->after('quota');
            $table->string('branch_code')->nullable()->after('branch_name');
            $table->string('challan_image')->nullable()->after('branch_code');
            $table->enum('fee_status', ['paid', 'unpaid'])->default('unpaid')->after('challan_image');

            $table->bigInteger('amount')->nullable();

            $table->unsignedTinyInteger('tier'); 
            $table->enum('status', ['NotCompleted','Pending', 'Approved', 'Rejected'])->default('Pending');

            $table->unsignedBigInteger('district_id')->nullable()->after('businessType');
            $table->unsignedBigInteger('tehsil_id')->nullable()->after('district_id');
            $table->unsignedBigInteger('business_category_id')->nullable()->after('tehsil_id');
            $table->unsignedBigInteger('business_sub_category_id')->nullable()->after('business_category_id');
            $table->unsignedBigInteger('branch_id')->nullable()->after('quota');
            $table->string('cnic_front')->nullable()->after('branch_id');
            $table->string('cnic_back')->nullable()->after('cnic_front');

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
