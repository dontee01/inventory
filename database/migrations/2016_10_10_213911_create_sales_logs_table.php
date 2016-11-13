<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->integer('item_id');
            $table->string('d_name');
            $table->string('transaction_ref');
            $table->string('i_name');
            $table->tinyInteger('is_rgb');
            $table->string('qty');
            $table->string('qty_bottle');
            $table->string('qty_content');
            $table->decimal('total', 10, 2);
            $table->decimal('amount_paid', 10, 2);
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
        Schema::drop('sales_logs');
    }
}
