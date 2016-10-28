<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->integer('categories_id');
            $table->string('i_name');
            $table->tinyInteger('is_rgb');
            $table->string('qty');
            $table->string('qty_bottle');
            $table->string('qty_content');
            $table->decimal('price_unit', 10, 2);
            // $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
