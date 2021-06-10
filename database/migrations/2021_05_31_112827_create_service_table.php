<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string("title", 64);
            $table->unsignedBigInteger('currency_id');
            $table->decimal('price',9,2);
            $table->date('first_payment_time');
            $table->date('last_payment_time');
            $table->timestamps();
        });
        Schema::table('service', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('company');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
}
