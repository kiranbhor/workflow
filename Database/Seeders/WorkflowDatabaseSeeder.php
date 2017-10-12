<?php

namespace Modules\Workflow\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkflowDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //Seed request status
        DB::table('workflow__workflowstatuses')->delete();

        $adminUser = DB::table('role_users')->where('role_id', '=', 1)->first();

        $status = [
            ["id"=>"1","status"=>"Pending","record_status"=>"A","label_class"=>"label-warning","is_closing_status"=>"0"],
            ["id"=>"2","status"=>"Approved","record_status"=>"A","label_class"=>"label-success","is_closing_status"=>"1"],
            ["id"=>"3","status"=>"Rejected","record_status"=>"A","label_class"=>"label-danger","is_closing_status"=>"1"],
            ["id"=>"4","status"=>"Forwarded","record_status"=>"A","label_class"=>"label-warning","is_closing_status"=>"1"],
            ["id"=>"5","status"=>"Cancelled","record_status"=>"A","label_class"=>"label-warning","is_closing_status"=>"1"],
            ["id"=>"6","status"=>"Stagged","record_status"=>"A","label_class"=>"label-default","is_closing_status"=>"0"],
            ["id"=>"7","status"=>"Assigned","record_status"=>"A","label_class"=>"label-primary","is_closing_status"=>"0"],
            ["id"=>"8","status"=>"In Progress","record_status"=>"A","label_class"=>"label-info","is_closing_status"=>"0"],
            ["id"=>"9","status"=>"Completed","record_status"=>"A","label_class"=>"label-success","is_closing_status"=>"1"],
            ["id"=>"10","status"=>"On Hold","record_status"=>"A","label_class"=>"label-warning","is_closing_status"=>"0"],
            ["id"=>"11","status"=>"Not Started","record_status"=>"A","label_class"=>"label-primary","is_closing_status"=>"0"]
        ];

        DB::table('workflow__workflowstatuses')->insert($status);

        //Seed request type
        DB::table('workflow__requesttypes')->delete();

        $requestTypes = [
            [
                'id' => '1',
                'default_assignee_user_id' => '1',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => '2,3,4',
                'type' => 'Late Coming Request',
                'validity_days' => '1',
                'additional_emails_to_notify' => '0',
                'notify_to_supervisor' => '1',
                'record_status' => 'A',
                'initial_request_status_id' => '1',
                'assign_to_supervisor' => '1',
                'send_email_notification' => NULL,
                'update_request_route' => 'admin.workflow.workflow.index',
                'create_request_route' => 'admin.workflow.workflows.getAssignedRequest',
                'repository' => 'Attendance,Attendance',
                'details_view' => 'late-coming',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '2',
                'default_assignee_user_id' => '1',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => '2,3,4',
                'type' => 'Previous Day Sign-out Request',
                'validity_days' => '30',
                'additional_emails_to_notify' => '0',
                'notify_to_supervisor' => '1',
                'record_status' => 'A',
                'initial_request_status_id' => '1',
                'assign_to_supervisor' => '1',
                'send_email_notification' => NULL,
                'update_request_route' => 'admin.workflow.workflow.index',
                'create_request_route' => 'admin.workflow.workflows.getAssignedRequest',
                'repository' => 'Attendance,Attendance',
                'details_view' => 'prev-day-signout',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '3',
                'default_assignee_user_id' => '1',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => '2,3.4',
                'type' => 'Delayed-Sign-in Request',
                'validity_days' => '30',
                'additional_emails_to_notify' => '0',
                'notify_to_supervisor' => '1',
                'record_status' => 'A',
                'initial_request_status_id' => '1',
                'assign_to_supervisor' => '1',
                'send_email_notification' => NULL,
                'update_request_route' => 'admin.workflow.workflow.index',
                'create_request_route' => 'admin.workflow.workflows.getAssignedRequest',
                'repository' => 'Attendance,Attendance',
                'details_view' => 'delay-in-signin',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '4',
                'default_assignee_user_id' => '1',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => '2,3.4',
                'type' => 'Task',
                'validity_days' => '0',
                'additional_emails_to_notify' => NULL,
                'notify_to_supervisor' => '1',
                'record_status' => NULL,
                'initial_request_status_id' => '7',
                'assign_to_supervisor' => NULL,
                'send_email_notification' => NULL,
                'update_request_route' => 'admin.project.tasks.getTaskAssigned',
                'create_request_route' => 'admin.project.tasks.viewTask',
                'repository' => 'Project,TaskUser',
                'details_view' => 'task',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '5',
                'default_assignee_user_id' => '1',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => '2,3,4',
                'type' => 'Leave Request',
                'validity_days' => '0',
                'additional_emails_to_notify' => '0',
                'notify_to_supervisor' => '1',
                'record_status' => NULL,
                'initial_request_status_id' => '1',
                'assign_to_supervisor' => '1',
                'send_email_notification' => NULL,
                'update_request_route' => 'admin.leave.leave.index',
                'create_request_route' => 'admin.workflow.workflows.getSingleAssignedRequest',
                'repository' => 'Leave,Leave',
                'details_view' => 'leave',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '6',
                'default_assignee_user_id' => '1',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => NULL,
                'type' => 'Request For Project Plan',
                'validity_days' => NULL,
                'additional_emails_to_notify' => NULL,
                'notify_to_supervisor' => '1',
                'record_status' => NULL,
                'initial_request_status_id' => '1',
                'assign_to_supervisor' => '1',
                'send_email_notification' => NULL,
                'update_request_route' => NULL,
                'create_request_route' => 'admin.workflow.workflow.index',
                'repository' => 'Project,TaskUser',
                'details_view' => 'project-plan',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '7',
                'default_assignee_user_id' => '1',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => NULL,
                'type' => 'Request For Building Plan',
                'validity_days' => NULL,
                'additional_emails_to_notify' => NULL,
                'notify_to_supervisor' => '1',
                'record_status' => NULL,
                'initial_request_status_id' => '1',
                'assign_to_supervisor' => NULL,
                'send_email_notification' => NULL,
                'update_request_route' => NULL,
                'create_request_route' => 'admin.workflow.workflows.getSingleAssignedRequest',
                'repository' => 'Project,Project',
                'details_view' => 'building-plan',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '9',
                'default_assignee_user_id' => '4',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => '2,3,4',
                'type' => 'Infrastructure Services',
                'validity_days' => '30',
                'additional_emails_to_notify' => '',
                'notify_to_supervisor' => '0',
                'record_status' => 'A',
                'initial_request_status_id' => 1,
                'assign_to_supervisor' => '0',
                'send_email_notification' => NULL,
                'update_request_route' => '',
                'create_request_route' => 'admin.workflow.workflow.index',
                'repository' => 'Workflow,Workflow',
                'details_view' => 'infrastructure',
                'show_approve_btn'=>0,
                'show_reject_btn'=>0,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>0,
                'show_close_btn' => 1
            ],
            [
                'id' => '10',
                'default_assignee_user_id' => '4',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '1',
                'closing_status_ids' => '2,3,4',
                'type' => 'Delay-signout-Request',
                'validity_days' => '30',
                'additional_emails_to_notify' => NULL,
                'notify_to_supervisor' => '0',
                'record_status' => NULL,
                'initial_request_status_id' => 1,
                'assign_to_supervisor' => NULL,
                'send_email_notification' => NULL,
                'update_request_route' => 'admin.workflow.workflow.index',
                'create_request_route' => 'admin.workflow.workflows.getAssignedRequest',
                'repository' => 'Attendance,Attendance',
                'details_view' => 'signout-delay',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '11',
                'default_assignee_user_id' => '4',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '0',
                'closing_status_ids' => '',
                'type' => 'Event',
                'validity_days' => NULL,
                'additional_emails_to_notify' => NULL,
                'notify_to_supervisor' => '1',
                'record_status' => NULL,
                'initial_request_status_id' => '',
                'assign_to_supervisor' => '0',
                'send_email_notification' => '1',
                'update_request_route' => NULL,
                'create_request_route' => 'admin.project.project.getEvents',
                'repository' => 'Project,TaskUser',
                'details_view' => 'event-details',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ],
            [
                'id' => '12',
                'default_assignee_user_id' => '4',
                'default_designation_id' => '0',
                'default_dept_id' => '1',
                'notification_group_id' => '0',
                'closing_status_ids' => '5',
                'type' => 'Cancel Leave Request',
                'validity_days' => '0',
                'additional_emails_to_notify' => '0',
                'notify_to_supervisor' => '1',
                'record_status' => NULL,
                'initial_request_status_id' => '2',
                'assign_to_supervisor' => '1',
                'send_email_notification' => NULL,
                'update_request_route' => 'admin.leave.leave.index',
                'create_request_route' => 'admin.workflow.workflows.getAssignedRequest',
                'repository' => 'Leave,Leave',
                'details_view' => 'cancel-leave',
                'show_approve_btn'=>1,
                'show_reject_btn'=>1,
                'show_forward_btn'=>1,
                'show_cancel_btn'=>1,
                'show_close_btn'=>0
            ]
        ];

        DB::table('workflow__requesttypes')->insert($requestTypes);


        DB::table('workflow__workflowpriorities')->delete();

        $requestPriority = [
            ['priority'=>'High','css_class' =>'label-danger'],
            ['priority'=>'Medium','css_class' =>'label-info'],
            ['priority'=>'Low','css_class' =>'label-success'],
        ];

        DB::table('workflow__workflowpriorities')->insert($requestPriority);




    }
}
