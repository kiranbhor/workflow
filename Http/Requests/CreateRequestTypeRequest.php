<?php

namespace Modules\Workflow\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateRequestTypeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => 'required|max:255',
            'parent_request_id' => 'required|max:255',
            'sequence_no' => 'required|max:255',
            'description' => 'required|max:255',
            'send_email_notification' => 'required|max:255',
            'default_assignee_user_id' => 'required|max:255',
            'default_designation_id' => 'required|max:255',
            'default_dept_id' => 'max:255',
            'notification_group_id' => 'max:255',
            'closing_status_ids' => 'max:255',
            'validity_days' => 'max:255',
            'additional_emails_to_notify' => 'max:255',
            'notify_to_supervisor' => 'max:255',
            'initial_request_status_id' => 'max:255',
            'assign_to_supervisor' => 'max:255',
            'update_request_route' => 'max:255',
            'create_request_route' => 'max:255',
            'repository' => 'max:255'
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
