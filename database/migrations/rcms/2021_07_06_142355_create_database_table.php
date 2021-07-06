<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('database', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->string("db", "64");
            $table->string("host", "64");
            $table->string("port", "64");
            $table->string("username", "64");
            $table->string("password", "64");
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('database', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('service');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('database');
    }
}
