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
            ['id' => '20','request_type_id' => '1','status' => 'Pending Admin Approval','sequence_no' => '1','label_class' => 'lbl lbl-info','is_closing_status' => NULL,'record_status' => 'A','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-22 18:35:50','updated_at' => '2017-10-22 20:11:54','deleted_at' => NULL,'assign_to_employee' => NULL,'assign_to_designation' => NULL,'assign_to_department' => '2','worklow_place' => 'pending_admin_approval'],
            ['id' => '21','request_type_id' => '1','status' => 'Pending Accounting Approval','sequence_no' => '2','label_class' => 'lbl-info','is_closing_status' => NULL,'record_status' => 'A','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-22 18:36:20','updated_at' => '2017-10-22 18:36:20','deleted_at' => NULL,'assign_to_employee' => NULL,'assign_to_designation' => NULL,'assign_to_department' => '3','worklow_place' => 'pending_accounting_approval'],
            ['id' => '22','request_type_id' => '1','status' => 'Approved','sequence_no' => '3','label_class' => 'lbl-info','is_closing_status' => NULL,'record_status' => 'A','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-22 18:37:27','updated_at' => '2017-10-22 18:37:27','deleted_at' => NULL,'assign_to_employee' => NULL,'assign_to_designation' => NULL,'assign_to_department' => '2','worklow_place' => 'approved'],
            ['id' => '23','request_type_id' => '1','status' => 'Rejected','sequence_no' => '4','label_class' => 'lbl-info','is_closing_status' => NULL,'record_status' => 'A','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-22 18:37:49','updated_at' => '2017-10-23 11:43:18','deleted_at' => NULL,'assign_to_employee' => NULL,'assign_to_designation' => NULL,'assign_to_department' => '2','worklow_place' => 'rejected'],
            ['id' => '24','request_type_id' => '1','status' => 'Invoice Generated','sequence_no' => '5','label_class' => 'lbl lbl-info','is_closing_status' => '1','record_status' => 'A','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-22 18:38:24','updated_at' => '2017-10-22 18:38:24','deleted_at' => NULL,'assign_to_employee' => NULL,'assign_to_designation' => NULL,'assign_to_department' => '2','worklow_place' => 'invoice_generated'],
            ['id' => '25','request_type_id' => '2','status' => 'Generated','sequence_no' => '1','label_class' => NULL,'is_closing_status' => NULL,'record_status' => 'A','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-24 21:34:49','updated_at' => '2017-10-24 21:34:49','deleted_at' => NULL,'assign_to_employee' => NULL,'assign_to_designation' => NULL,'assign_to_department' => '3','worklow_place' => 'generated'],
            ['id' => '26','request_type_id' => '2','status' => 'Partially Paid','sequence_no' => '2','label_class' => NULL,'is_closing_status' => NULL,'record_status' => 'A','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-24 21:35:24','updated_at' => '2017-10-24 21:35:24','deleted_at' => NULL,'assign_to_employee' => NULL,'assign_to_designation' => NULL,'assign_to_department' => '3','worklow_place' => 'Partially Paid'],
            ['id' => '27','request_type_id' => '2','status' => 'Paid','sequence_no' => '3','label_class' => NULL,'is_closing_status' => NULL,'record_status' => 'A','created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-24 21:35:47','updated_at' => '2017-10-24 21:35:47','deleted_at' => NULL,'assign_to_employee' => NULL,'assign_to_designation' => NULL,'assign_to_department' => '3','worklow_place' => 'paid']
        ];

        DB::table('workflow__workflowstatuses')->insert($status);

        //Seed request type
        DB::table('workflow__requesttypes')->delete();

        $requestTypes = [
            ['id' => '1','type' => 'Order','parent_request_id' => NULL,'sequence_no' => '1','description' => 'Descsdsd','default_assignee_user_id' => NULL,'default_designation_id' => NULL,'default_dept_id' => '2','notification_group_id' => NULL,'closing_status_ids' => NULL,'validity_days' => NULL,'additional_emails_to_notify' => NULL,'notify_to_supervisor' => '0','initial_request_status_id' => '20','assign_to_supervisor' => NULL,'send_email_notification' => NULL,'update_request_route' => NULL,'create_request_route' => NULL,'repository' => NULL,'show_close_btn' => '0','details_view' => NULL,'show_approve_btn' => '1','show_reject_btn' => '1','show_forward_btn' => '1','show_cancel_btn' => '1','record_status' => NULL,'created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-17 09:58:29','updated_at' => '2017-10-22 19:18:59','deleted_at' => NULL],
            ['id' => '2','type' => 'Invoice','parent_request_id' => NULL,'sequence_no' => '1','description' => 'Invoice','default_assignee_user_id' => NULL,'default_designation_id' => NULL,'default_dept_id' => NULL,'notification_group_id' => NULL,'closing_status_ids' => '27','validity_days' => NULL,'additional_emails_to_notify' => NULL,'notify_to_supervisor' => '0','initial_request_status_id' => '25','assign_to_supervisor' => NULL,'send_email_notification' => NULL,'update_request_route' => NULL,'create_request_route' => NULL,'repository' => NULL,'show_close_btn' => '0','details_view' => NULL,'show_approve_btn' => '0','show_reject_btn' => '0','show_forward_btn' => '0','show_cancel_btn' => '0','record_status' => NULL,'created_by' => '1','updated_by' => NULL,'deleted_by' => NULL,'created_at' => '2017-10-24 21:33:57','updated_at' => '2017-10-24 21:36:31','deleted_at' => NULL]
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
