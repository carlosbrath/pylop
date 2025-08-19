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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); // bigint(20) unsigned auto_increment
            $table->string('model', 100); // model name
            $table->unsignedBigInteger('model_id')->nullable(); // related model id
            $table->string('action', 20); // action performed
            $table->longText('changes')->nullable(); // changes made
            $table->unsignedBigInteger('user_id')->nullable(); // user who did the action
            $table->string('performed_by')->nullable(); 
            $table->longText('meta_info')->nullable(); // extra info
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
