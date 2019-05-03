<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsageStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usage_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('current_orders')->default(46);
            $table->integer('loyal_customers')->default(3047);
            $table->integer('active_writers')->default(2541);
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
        Schema::dropIfExists('usage_statistics');
    }
}
