<?php

namespace Modules\Workflow\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class NotificationSubscription extends Model
{

    protected $table = 'workflow__notificationsubscriptions';
    protected $guarded = ['id'];
}
