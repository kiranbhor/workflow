<?php

namespace Modules\Workflow\Repositories\Cache;

use Modules\Workflow\Repositories\WorkflowPriorityRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWorkflowPriorityDecorator extends BaseCacheDecorator implements WorkflowPriorityRepository
{
    public function __construct(WorkflowPriorityRepository $workflowpriority)
    {
        parent::__construct();
        $this->entityName = 'workflow.workflowpriorities';
        $this->repository = $workflowpriority;
    }
}
