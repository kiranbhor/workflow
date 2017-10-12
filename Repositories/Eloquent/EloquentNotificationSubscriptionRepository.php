<?php

namespace Modules\Workflow\Repositories\Eloquent;

use Modules\Workflow\Repositories\NotificationSubscriptionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentNotificationSubscriptionRepository extends EloquentBaseRepository implements NotificationSubscriptionRepository
{
    /**
     * return requests user is unsubscribed to
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUnsubscribedRequestTypes($userId){
        return $this->getByAttributesWithColumns(['user_id' => $userId],['id']);
    }
}
