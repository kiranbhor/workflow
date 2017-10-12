<?php

namespace Modules\Workflow\Repositories\Cache;

use Modules\Workflow\Repositories\RequestTypeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRequestTypeDecorator extends BaseCacheDecorator implements RequestTypeRepository
{
    public function __construct(RequestTypeRepository $requesttype)
    {
        parent::__construct();
        $this->entityName = 'workflow.requesttypes';
        $this->repository = $requesttype;
    }
}
