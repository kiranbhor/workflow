<?php

namespace Modules\Workflow\Repositories\Cache;

use Modules\Workflow\Repositories\NotificationRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNotificationDecorator extends BaseCacheDecorator implements NotificationRepository
{
    public function __construct(NotificationRepository $notification)
    {
        parent::__construct();
        $this->entityName = 'workflow.notifications';
        $this->repository = $notification;
    }
}
