<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->timestamps();

            $table->integer('order_no');
            $table->string('title');
            $table->string('amount');
            $table->integer('no_pages');
            $table->integer('no_words');
            $table->integer('cpp');//no_pages * no_words
            $table->dateTime('bid_expiry');
            $table->integer('order_assign_type');
            /*1 - Bid
            2 - Take
            3 - Manual*/
            $table->dateTime('deadline');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
