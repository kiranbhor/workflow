<?php namespace Modules\Workflow\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\User\Contracts\Authentication;
use Modules\Workflow\Repositories\NotificationRepository;

class NotificationViewComposer {
	/**
	 * @var NotificationRepository
	 */
	private $notification;
	/**
	 * @var Authentication
	 */
	private $auth;

	/**
	 * @var Reauest
	 */
	private $request;

	public function __construct(NotificationRepository $notification, Authentication $auth, Request $request) {
		$this->notification = $notification;
		$this->auth = $auth;
		$this->request = $request;
	}

	public function compose(View $view) {

		$userId = $this->auth->user()->id;

		$view->with('test','mvc');

        if(is_module_enabled('Project')){
            $taskNotifications = $this->notification->getTaskNotifications($userId);
            $view->with('taskNotifications', $taskNotifications);
        }

        if(is_module_enabled("Attendance")){
            $isSignedIn = app('Modules\Attendance\Repositories\AttendanceRepository')->isSignedIn($userId);
            $view->with('isSignedIn', $isSignedIn);
        }

        if(is_module_enabled("Leave")){
            $leaveNotifications = $this->notification->getLeaveNotifications($userId);
            $view->with('leaveNotifications',$leaveNotifications);
        }


        $notificationSubscriptionRepo = app('Modules\Workflow\Repositories\NotificationSubscriptionRepository');

        //Load user notifications
        $notifications = $this->notification->latestForUser($userId, $notificationSubscriptionRepo->getUnsubscribedRequestTypes($userId));
        $view->with('notifications',$notifications);

        $isSignedIn = $this->auth->user()->is_signin;

        $view->with('isSignedIn',$isSignedIn);


	}
}
