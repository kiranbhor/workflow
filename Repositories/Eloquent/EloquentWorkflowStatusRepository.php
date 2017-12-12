<?php

namespace Modules\Workflow\Repositories\Eloquent;

use Modules\Workflow\Entities\WorkflowStatus;
use Modules\Workflow\Repositories\WorkflowStatusRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentWorkflowStatusRepository extends EloquentBaseRepository implements WorkflowStatusRepository
{
    /**
     * @param $requestType  This can be a request type object or request type name
     * @param null $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getRequestClosingStatus($requestType,$columns = null){

        $requestTypeObject = null;

        if(is_string($requestType)){
            $requestTypeObject = app(getRepoName('RequestType','Workflow'))
                ->findByAttributes(['type'=> $requestType]);
        }
        else{
            $requestTypeObject = $requestType;
        }

        return $this->getByAttributesWithColumns([
            'request_type_id'=>$requestTypeObject->id,
            'is_closing_status'=>true
        ],$columns,'sequence_no');
    }

}
