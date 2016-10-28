<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_ref');
            $table->string('s_name');
            $table->string('i_name');
            $table->tinyInteger('is_rgb');
            $table->tinyInteger('is_bottle');
            $table->tinyInteger('no_exchange');
            $table->string('qty');
            $table->string('qty_bottle');
            $table->decimal('price_unit', 10, 2);
            $table->decimal('price_total', 10, 2);
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
        Schema::drop('purchase_logs');
    }
}
