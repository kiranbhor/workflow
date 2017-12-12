<?php

namespace Modules\Workflow\Repositories\Cache;

use Modules\Workflow\Repositories\WorkflowSequenceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWorkflowSequenceDecorator extends BaseCacheDecorator implements WorkflowSequenceRepository
{
    public function __construct(WorkflowSequenceRepository $workflowsequence)
    {
        parent::__construct();
        $this->entityName = 'workflow.workflowsequences';
        $this->repository = $workflowsequence;
    }
}
