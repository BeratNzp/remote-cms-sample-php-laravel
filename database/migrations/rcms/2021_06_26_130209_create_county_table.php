<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('county', function (Blueprint $table) {
            $table->id();
            $table->string("title", 64);
            $table->unsignedBigInteger('city_id');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('county', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('county', function (Blueprint $table) {
            //
        });
    }
}
