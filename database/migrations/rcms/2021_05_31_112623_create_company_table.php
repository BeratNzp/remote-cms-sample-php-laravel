<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string("title", "64");
            $table->string("company_title", "256");
            $table->timestamps();
        });
        Schema::table('company', function (Blueprint  $table) {
            $table->softDeletes();
        });
        Schema::table('user', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('company');
            $table->foreign('current_company_id')->references('id')->on('company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
