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
        Schema::create('midjorneys', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->index('user_id');
            $table->string('name')->nullable();
            $table->string('link')->nullable();
            $table->string('status')->nullable();
            $table->string('task_uuid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('midjorneys');
    }
};
