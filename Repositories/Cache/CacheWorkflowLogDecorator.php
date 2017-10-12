<?php

namespace Modules\Workflow\Repositories\Cache;

use Modules\Workflow\Repositories\WorkflowLogRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWorkflowLogDecorator extends BaseCacheDecorator implements WorkflowLogRepository
{
    public function __construct(WorkflowLogRepository $workflowlog)
    {
        parent::__construct();
        $this->entityName = 'workflow.workflowlogs';
        $this->repository = $workflowlog;
    }
}
