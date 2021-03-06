<?php

namespace Modules\Workflow\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateRequestTypeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => 'required|max:255',
            'description' => 'required|max:255',
            'closing_status_ids' => 'required',
            'initial_request_status_id' => 'required|max:255'
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
