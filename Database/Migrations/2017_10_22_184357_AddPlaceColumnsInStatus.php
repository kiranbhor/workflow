<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaceColumnsInStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workflow__workflowstatuses', function (Blueprint $table) {
            $table->string('worklow_place');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workflow__workflowstatuses', function (Blueprint $table) {
            $table->dropColumn('worklow_place');
        });
    }
}
