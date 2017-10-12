<?php

namespace Modules\Workflow\Repositories\Eloquent;

use Modules\Workflow\Repositories\NotificationRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentNotificationRepository extends EloquentBaseRepository implements NotificationRepository
{
    /**
     * Get latest notifications for user
     * @param $userId
     * @param null $exceptTypes
     * @param null $maxNotifications
     * @return mixed
     */
    public function latestForUser($userId, $exceptTypes = null,$maxNotifications = null)
    {
        $query = $this->model->where('user_id','=',$userId)->where('is_read','=',false);

        if($exceptTypes != null){
            $query = $query->whereNotIn('type',$exceptTypes);
        }

        $maxNotifications = isset($maxNotifications)?:Config('asgard.workflow.config.notification.max_notification_to_show',10);

        return  $query->orderBy('created_at', 'desc')->take($maxNotifications)->get();
    }

    /**
     * Mark the given notification id as "read"
     * @param int $notificationId
     * @return bool
     */
    public function markNotificationAsRead($notificationId)
    {
        $notification = $this->find($notificationId);
        $notification->is_read = true;

        return $notification->save();
    }

    /**
     * Get all notifications
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find notification by id
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get all the only initial 10 notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allForUser($userId)
    {
        $maxNotifications = Config('asgard.workflow.config.notification.max_notification_to_show',10);
        return $this->model->where('user_id','=',$userId)->orderBy('created_at', 'desc')->take($maxNotifications)->get();
    }

    /**
     * Get all the notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllForUser($userId)
    {
        return $this->model->where('user_id','=',$userId)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get all the notifications for the given type Based Type
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latestForUserBasedOnType($userId,$types)
    {
        $maxNotifications = Config('asgard.workflow.config.notification.max_notification_to_show',10);
        return $this->model->where('user_id','=',$userId)->whereIn('type', $types)->where('is_read','=', false)->orderBy('created_at', 'desc')->take($maxNotifications)->get();
    }

    /**
     * Get all the unread notifications for the given user id
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allUnreadForUser($userId)
    {
        return $this->model->where('user_id','=',$userId)->where('is_read','=',false)->orderBy('created_at', 'desc')->get();
    }

    /**
     * Delete all the notifications for the given user
     * @param int $userId
     * @return bool
     */
    public function deleteAllForUser($userId)
    {
        return $this->model->where('user_id','=',$userId)->delete();
    }

    /**
     * Delete the selected notifications
     * @param $notification
     * @return mixed
     */
    public function deleteSelected($notification)
    {
        return $this->model->whereIn('id', $notification)->where('is_read','=',true)->delete();
    }


    /**
     * Mark all the notifications for the given user as read
     * @param int $userId
     * @return bool
     */
    public function markAllAsReadForUser($userId)
    {
        return $this->model->where('user_id','=',$userId)->update(['is_read' => true]);
    }


    /**
     * Get task notifications for user
     * @param $userId
     * @return mixed
     */
    public function getTaskNotifications($userId){

        $taskRequestId  = getRequestTypeId('Task');
        return $this->model->where('user_id','=',$userId)->where('is_read','=',false)->where('request_type_id','=',$taskRequestId);
    }

    /**
     * Load leave notifications for user
     * @param $userId
     * @return mixed
     */
    public function getLeaveNotifications($userId){

        $leaveRequestId  = getRequestTypeId('Leave');
        return $this->model->where('user_id','=',$userId)->where('is_read','=',false)->where('request_type_id','=',$leaveRequestId);
    }

    /**
     *
     */
    public function sendNotification($channels){
        event(new \Modules\Workflow\Events\NotificationEvent($channels));
    }
}
