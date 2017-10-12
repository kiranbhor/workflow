<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Workflow\Entities\Notification;
use Modules\Workflow\Http\Requests\CreateNotificationRequest;
use Modules\Workflow\Http\Requests\UpdateNotificationRequest;
use Modules\Workflow\Repositories\NotificationRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class NotificationController extends AdminBaseController
{
    /**
     * @var NotificationRepository
     */
    private $notification;

    public function __construct(NotificationRepository $notification)
    {
        parent::__construct();

        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$notifications = $this->notification->all();

        return view('workflow::admin.notifications.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('workflow::admin.notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNotificationRequest $request
     * @return Response
     */
    public function store(CreateNotificationRequest $request)
    {
        $this->notification->create($request->all());

        return redirect()->route('admin.workflow.notification.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('workflow::notifications.title.notifications')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Notification $notification
     * @return Response
     */
    public function edit(Notification $notification)
    {
        return view('workflow::admin.notifications.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Notification $notification
     * @param  UpdateNotificationRequest $request
     * @return Response
     */
    public function update(Notification $notification, UpdateNotificationRequest $request)
    {
        $this->notification->update($notification, $request->all());

        return redirect()->route('admin.workflow.notification.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('workflow::notifications.title.notifications')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Notification $notification
     * @return Response
     */
    public function destroy(Notification $notification)
    {
        $this->notification->destroy($notification);

        return redirect()->route('admin.workflow.notification.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('workflow::notifications.title.notifications')]));
    }
}
