<?php

namespace Modules\Workflow\Repositories\Cache;

use Modules\Workflow\Repositories\WorkflowRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWorkflowDecorator extends BaseCacheDecorator implements WorkflowRepository
{
    public function __construct(WorkflowRepository $workflow)
    {
        parent::__construct();
        $this->entityName = 'workflow.workflows';
        $this->repository = $workflow;
    }
}
