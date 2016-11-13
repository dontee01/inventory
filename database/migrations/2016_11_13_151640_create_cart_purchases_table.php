<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_users_id');
            $table->integer('item_id');
            $table->string('transaction_ref');
            $table->string('cart_session');
            $table->string('s_name');
            $table->string('i_name');
            $table->tinyInteger('is_rgb');
            $table->tinyInteger('is_bottle');
            $table->tinyInteger('no_exchange');
            $table->string('qty_bottle');
            $table->string('qty');
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
        Schema::drop('cart_purchases');
    }
}
