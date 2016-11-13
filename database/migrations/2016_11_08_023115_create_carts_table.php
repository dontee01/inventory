<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_users_id');
            $table->integer('sales_users_id');
            $table->integer('item_id');
            $table->string('transaction_ref');
            $table->string('cart_session');
            $table->string('d_name');
            $table->string('i_name');
            $table->string('c_name');
            $table->tinyInteger('is_rgb');
            $table->string('qty_content');
            $table->string('qty_bottle');
            $table->string('qty');
            $table->string('returned_qty');
            $table->string('returned_bottle');
            $table->decimal('price_unit', 10, 2);
            $table->decimal('price_total', 10, 2);
            $table->tinyInteger('is_confirmed');
            $table->tinyInteger('deleted');
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
        Schema::drop('carts');
    }
}
