<?php

namespace Modules\Workflow\Repositories\Cache;

use Modules\Workflow\Repositories\NotificationSubscriptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheNotificationSubscriptionDecorator extends BaseCacheDecorator implements NotificationSubscriptionRepository
{
    public function __construct(NotificationSubscriptionRepository $notificationsubscription)
    {
        parent::__construct();
        $this->entityName = 'workflow.notificationsubscriptions';
        $this->repository = $notificationsubscription;
    }
}
