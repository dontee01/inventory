<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBottleDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bottle_debtors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->string('transaction_ref');
            $table->string('i_name');
            $table->string('d_name');
            $table->string('error_type');
            $table->string('qty_bottle');
            $table->decimal('amount_paid', 10, 2);
            $table->tinyInteger('is_rgb_content');
            $table->tinyInteger('is_cleared');
            $table->string('comment');
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
        Schema::drop('bottle_debtors');
    }
}
