<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeaconListings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacon_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('beacon_uuid',50)->comment = "beacon uuid";
            $table->Integer('location_x')->comment = "longitude";
            $table->Integer('location_y')->comment = "latitude";
            $table->string('desc')->comment = "location description";
            $table->Integer('created_on');
            $table->Integer('updated_on');
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
