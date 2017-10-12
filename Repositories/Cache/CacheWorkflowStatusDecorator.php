<?php

namespace Modules\Workflow\Repositories\Cache;

use Modules\Workflow\Repositories\WorkflowStatusRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWorkflowStatusDecorator extends BaseCacheDecorator implements WorkflowStatusRepository
{
    public function __construct(WorkflowStatusRepository $workflowstatus)
    {
        parent::__construct();
        $this->entityName = 'workflow.workflowstatuses';
        $this->repository = $workflowstatus;
    }
}
