<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkflowTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') == "DEV") {
            $this->down();
        }

        Schema::create('workflow__requesttypes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type')->unique();
            $table->integer('parent_request_id')->unsigned();
            $table->integer('sequence_no')->nullable();
            $table->text('description')->nullable();
            $table->integer('default_assignee_user_id')->nullable();
            $table->integer('default_designation_id')->nullable();
            $table->integer('default_dept_id')->nullable();
            $table->integer('notification_group_id')->nullable();
            $table->string('closing_status_ids')->nullable();
            $table->integer('validity_days')->nullable();
            $table->text('additional_emails_to_notify')->nullable();
            $table->boolean('notify_to_supervisor')->default(false);
            $table->string('initial_request_status_id')->nullable();
            $table->integer('assign_to_supervisor')->nullable();
            $table->boolean('send_email_notification')->nullable();
            $table->string('update_request_route', 100)->nullable();
            $table->string('create_request_route', 100)->nullable();
            $table->string('repository')->nullable();
            $table->boolean('show_close_btn')->default(false);
            $table->string('details_view')->nullable();
            $table->boolean('show_approve_btn')->default(true);
            $table->boolean('show_reject_btn')->default(true);
            $table->boolean('show_forward_btn')->default(true);
            $table->boolean('show_cancel_btn')->default(true);
            $table->string('record_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workflow__workflowpriorities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('priority')->nullable(); 
            $table->unsignedInteger('request_type_id')->nullable();
            $table->integer('sequence_no')->nullable();
            $table->string('css_class')->nullable();
            $table->string('task_default')->nullable();
            $table->string('record_status')->default("A")->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->unique('priority');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workflow__workflowstatuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('request_type_id')->default(null)->nullable();
            $table->string('status');
            $table->integer('sequence_no')->nullable();
            $table->string('label_class', 50)->nullable();
            $table->boolean('is_closing_status')->nullable();
            $table->string('record_status')->nullable()->default("A");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->unique('status');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workflow__notifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('user_id')->references('id')->on('users');
            $table->unsignedInteger('request_type_id')->references('id')->on('workflow__requesttypes');


            $table->string('type', 25)->nullable();
            $table->string('header')->nullable();
            $table->string('title');
            $table->text('link');
            $table->text('message');
            $table->dateTime('date_added')->nullable();
            $table->string('icon_class')->nullable();
            $table->boolean('is_read')->nullable();
            $table->string('record_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workflow__workflows', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('request_type_id')->unsigned()->nullable();
            $table->foreign('request_type_id')->references('id')->on('workflow__requesttypes');

            $table->integer('request_ref_id')->nullable();

            $table->integer('request_status_id')->unsigned()->nullable();
            $table->foreign('request_status_id')->references('id')->on('workflow__workflowstatuses');

            $table->integer('assigned_to_user_id')->unsigned()->nullable();
            $table->foreign('assigned_to_user_id')->references('id')->on('users');

            $table->integer('assigned_to_designation_id')->nullable();
            $table->integer('assigned_to_department_id')->nullable();
            $table->integer('assignee_type_id')->nullable();

            $table->integer('requester_id')->unsigned()->nullable();
            $table->foreign('requester_id')->references('id')->on('users');

            $table->integer('request_workflow_status_id')->unsigned()->nullable();
            $table->foreign('request_workflow_status_id')->references('id')->on('workflow__workflowstatuses');

            $table->date('request_date')->nullable();
            $table->boolean('is_expired')->nullable();
            $table->text('user_note')->nullable();
            $table->text('supervisor_note')->nullable();
            $table->text('request_text')->nullable();
            $table->dateTime('datetime_added')->nullable();
            $table->boolean('is_open')->nullable();
            $table->text('request_data')->nullable();
            $table->text('assignee_comment')->nullable();
            $table->string('record_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('workflow__workflowlogs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('request_workflow_id')->unsigned();
            $table->foreign('request_workflow_id')->references('id')->on('workflow__workflows');

            $table->integer('from_request_status_id')->unsigned();
            $table->foreign('from_request_status_id')->references('id')->on('workflow__workflowstatuses');

            $table->integer('to_request_status_id')->unsigned();
            $table->foreign('to_request_status_id')->references('id')->on('workflow__workflowstatuses');

            $table->integer('from_emp_id')->unsigned();
            $table->foreign('from_emp_id')->references('id')->on('users');

            $table->integer('to_emp_id')->unsigned();
            $table->foreign('to_emp_id')->references('id')->on('users');

            $table->integer('to_designation_id');
            $table->integer('to_department_id');
            $table->integer('assignee_type_id');
            $table->dateTime('log_date');
            $table->string('action');
            $table->string('supervisor_comment')->nullable();
            $table->boolean('is_closed');
            $table->string('record_status')->nullable()->default("A");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('workflow__notificationsubscriptions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('user_id')->references('id')->on('users');
            $table->unsignedInteger('request_type')->references('id')->on('workflow__requesttypes');
            $table->timestamp('unsubscribed_time');
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
        Schema::dropIfExists('workflow__notificationsubscriptions');
        Schema::dropIfExists('workflow__workflowlogs');
        Schema::dropIfExists('workflow__workflows');
        Schema::dropIfExists('workflow__notifications');
        Schema::dropIfExists('workflow__requesttypes');
        Schema::dropIfExists('workflow__workflowstatuses');
        Schema::dropIfExists('workflow__workflowpriorities');

    }
}
