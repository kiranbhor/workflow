<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequestAssigneeColumnsInStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workflow__workflowstatuses', function (Blueprint $table) {
           $table->unsignedInteger('assign_to_employee')->references('id')->on('user')->nullable();
           $table->unsignedInteger('assign_to_designation')->references('id')->on('master__designations')->nullable();
           $table->unsignedInteger('assign_to_department')->references('id')->on('master__departments')->nullable();
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
            $table->dropColumn(['assign_to_employee','assign_to_designation','assign_to_department']);
        });
    }
}
