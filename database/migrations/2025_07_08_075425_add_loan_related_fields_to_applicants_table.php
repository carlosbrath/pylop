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
        Schema::table('applicants', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('district_id')->nullable()->after('businessType');
            $table->unsignedBigInteger('tehsil_id')->nullable()->after('district_id');
            $table->unsignedBigInteger('business_category_id')->nullable()->after('tehsil_id');
            $table->unsignedBigInteger('business_sub_category_id')->nullable()->after('business_category_id');
            $table->unsignedBigInteger('branch_id')->nullable()->after('quota');
            $table->string('cnic_front')->nullable()->after('branch_id');
            $table->string('cnic_back')->nullable()->after('cnic_front');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'district_id',
                'tehsil_id',
                'business_category_id',
                'business_sub_category_id',
                'branch_id',
            ]);
        });
    }
};
