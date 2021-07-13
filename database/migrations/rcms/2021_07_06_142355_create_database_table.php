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
            $table->unsignedBigInteger('company_id');
            $table->string("ip", "64")->nullable();
            $table->string("port", "5")->nullable();
            $table->string("username", "256")->nullable();
            $table->string("password", "256")->nullable();
            $table->string("database", "256");
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('database', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('company');
        });
        Schema::table('user', function (Blueprint $table) {
            $table->foreign('current_database_id')->references('id')->on('database');
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
