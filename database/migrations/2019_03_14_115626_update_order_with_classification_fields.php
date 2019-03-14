<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderWithClassificationFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('orders',function (Blueprint $table){
            $table->unsignedBigInteger('paper_type');
            $table->unsignedBigInteger('discipline');
            $table->unsignedBigInteger('education_level');
            $table->integer('type_of_service')->default(0); //0-Writing from scratch 1-Rewrite 2-editing
            $table->integer('writer_quality')->default(0); //0- standard - 1-premium 2-platinum

            //foreign integrity
            $table->foreign('paper_type')->references('id')->on('paper_types');
            $table->foreign('discipline')->references('id')->on('disciplines');
            $table->foreign('education_level')->references('id')->on('education_levels');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
