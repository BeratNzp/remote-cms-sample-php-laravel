<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\BooleanEnum;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::connection('panel_user')->create('product', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('up_category_id')->nullable();
            //$table->enum('type_id', CategoryType::getValues())->nullable();
            //$table->enum('can_sub_category', BooleanEnum::getValues())->default(BooleanEnum::False);
            //$table->enum('main_category', BooleanEnum::getValues())->default(BooleanEnum::False);
            $table->string("title", 64);
            $table->timestamps();
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
        Schema::connection('panel_user')->dropIfExists('product');
    }
}
