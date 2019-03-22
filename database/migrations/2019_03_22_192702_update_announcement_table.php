<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAnnouncementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('announcements',function (Blueprint $table){
           $table->boolean('status')->default(true); //true means the announcement is still to be viewed by users
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
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
