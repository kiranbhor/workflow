<?php

namespace Modules\Workflow\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateWorkflowStatusRequest extends BaseFormRequest
{
    public function rules()
    {
         return [
            'status' => 'required|max:255',
            'sequence_no' => 'required|max:255',
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
