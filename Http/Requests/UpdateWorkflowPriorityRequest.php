<?php

namespace Modules\Workflow\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateWorkflowPriorityRequest extends BaseFormRequest
{
    public function rules()
    {
         return [
            'priority' => 'required|unique:workflow__workflowpriorities,priority|max:255',
            'sequence_no' => 'required|max:255',
            'css_class' => 'required|max:255',
            'task_default' => 'required|max:255'
//            'sequence_no' => 'required|unique:filemanager__filetypecategories,name,'.$this->old_name.',name|max:255',
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
