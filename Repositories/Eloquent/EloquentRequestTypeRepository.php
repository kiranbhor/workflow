<?php

namespace Modules\Workflow\Repositories\Eloquent;

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
}
