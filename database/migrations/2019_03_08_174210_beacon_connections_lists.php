<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeaconConnectionsLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacon_connections_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('edge_name',70)->comment = "Edge names";
            $table->string('first_node',70)->comment = "node 1";
            $table->string('second_node',70)->comment = "node 2";
            $table->integer('distance')->comment = "distance between nodes";
            $table->string('direction_name',70)->comment = "direction names";
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

    }
}
