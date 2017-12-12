<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkflowLogColuns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workflow__workflowlogs', function (Blueprint $table) {

            $table->unsignedInteger('from_emp_id')->foreign('from_emp_id')->references('id')->on('users')->nullable()->change();
            $table->unsignedInteger('to_emp_id')->foreign('to_emp_id')->references('id')->on('users')->nullable()->change();
            $table->integer('to_designation_id')->nullable()->change();
            $table->integer('to_department_id')->nullable()->change();
            $table->integer('assignee_type_id')->nullable()->change();

            $table->integer('from_designation_id')->nullable();
            $table->integer('from_department_id')->nullable();

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
