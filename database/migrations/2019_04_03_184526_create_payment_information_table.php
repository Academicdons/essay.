<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mpesa_number')->nullable();
            $table->string('id_number')->nullable();
            $table->string('mpesa_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('payment_information');
    }
}
