<?php

namespace Modules\Workflow\Repositories\Eloquent;

use Modules\Workflow\Entities\RequestType;
use Modules\Workflow\Entities\WorkflowStatus;
use Modules\Workflow\Repositories\RequestTypeRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentRequestTypeRepository extends EloquentBaseRepository implements RequestTypeRepository
{
    /**
     * @param $requestTypeName
     * @return mixed
     */
    public function findRequestTypeByName($requestTypeName){
        return $this->findByAttributes(['type'=>$requestTypeName]);
    }


    /**
     * Create new request
     * @param $data
     */
    public function createNew($data){
        $requestType = new RequestType();
        $this->updateRequestType($requestType,$data);
    }

    /**
     * Update Request type
     * @param $requestType
     * @param $data
     */
    public function updateRequestType($requestType,$data){

        $requestType->fill($data);

        $requestType->closing_status_ids = $data['closing_status_ids'];
        $requestType->show_approve_btn = isset($data['show_approve_btn']);
        $requestType->show_reject_btn =isset($data['show_reject_btn']);
        $requestType->show_forward_btn = isset($data['show_forward_btn']);
        $requestType->show_cancel_btn = isset($data['show_cancel_btn']);
        $requestType->created_by = auth()->user()->id;

        $requestType->save();

    }

}
