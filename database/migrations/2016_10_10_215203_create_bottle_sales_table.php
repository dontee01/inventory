<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBottleSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bottle_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_users_id');
            $table->integer('sales_users_id');
            $table->string('transaction_ref');
            $table->string('d_name');
            $table->string('i_name');
            $table->string('c_name');
            $table->string('qty_bottle_content');
            $table->decimal('price_unit', 10, 2);
            $table->decimal('price_total', 10, 2);
            $table->string('comment');
            $table->tinyInteger('is_confirmed');
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
        Schema::drop('bottle_sales');
    }
}
