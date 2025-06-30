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
            $table->string('branch_name')->nullable()->after('quota');
            $table->string('branch_code')->nullable()->after('branch_name');
            $table->string('challan_image')->nullable()->after('branch_code');
            $table->enum('fee_status', ['paid', 'unpaid'])->default('unpaid')->after('challan_image');
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
            //
            $table->dropColumn(['branch_name', 'branch_code', 'challan_image', 'fee_status']);
        });
    }
};
