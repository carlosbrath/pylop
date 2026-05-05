<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->enum('type', ['manual', 'online'])->default('online')->after('id');
        });

        // Make optional fields nullable (raw SQL avoids doctrine/dbal requirement)
        DB::statement('ALTER TABLE applicants MODIFY COLUMN cnic_issue_date DATE NULL');
        DB::statement('ALTER TABLE applicants MODIFY COLUMN dob DATE NULL');
        DB::statement('ALTER TABLE applicants MODIFY COLUMN phone VARCHAR(255) NULL');
        DB::statement('ALTER TABLE applicants MODIFY COLUMN businessName VARCHAR(255) NULL');
        DB::statement('ALTER TABLE applicants MODIFY COLUMN businessAddress TEXT NULL');
        DB::statement('ALTER TABLE applicants MODIFY COLUMN permanentAddress TEXT NULL');
    }

    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
