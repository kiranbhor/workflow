<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Workflow\Entities\NotificationSubscription;
use Modules\Workflow\Http\Requests\CreateNotificationSubscriptionRequest;
use Modules\Workflow\Http\Requests\UpdateNotificationSubscriptionRequest;
use Modules\Workflow\Repositories\NotificationSubscriptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class NotificationSubscriptionController extends AdminBaseController
{
    /**
     * @var NotificationSubscriptionRepository
     */
    private $notificationsubscription;

    public function __construct(NotificationSubscriptionRepository $notificationsubscription)
    {
        parent::__construct();

        $this->notificationsubscription = $notificationsubscription;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$notificationsubscriptions = $this->notificationsubscription->all();

        return view('workflow::admin.notificationsubscriptions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('workflow::admin.notificationsubscriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNotificationSubscriptionRequest $request
     * @return Response
     */
    public function store(CreateNotificationSubscriptionRequest $request)
    {
        $this->notificationsubscription->create($request->all());

        return redirect()->route('admin.workflow.notificationsubscription.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('workflow::notificationsubscriptions.title.notificationsubscriptions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  NotificationSubscription $notificationsubscription
     * @return Response
     */
    public function edit(NotificationSubscription $notificationsubscription)
    {
        return view('workflow::admin.notificationsubscriptions.edit', compact('notificationsubscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NotificationSubscription $notificationsubscription
     * @param  UpdateNotificationSubscriptionRequest $request
     * @return Response
     */
    public function update(NotificationSubscription $notificationsubscription, UpdateNotificationSubscriptionRequest $request)
    {
        $this->notificationsubscription->update($notificationsubscription, $request->all());

        return redirect()->route('admin.workflow.notificationsubscription.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('workflow::notificationsubscriptions.title.notificationsubscriptions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  NotificationSubscription $notificationsubscription
     * @return Response
     */
    public function destroy(NotificationSubscription $notificationsubscription)
    {
        $this->notificationsubscription->destroy($notificationsubscription);

        return redirect()->route('admin.workflow.notificationsubscription.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('workflow::notificationsubscriptions.title.notificationsubscriptions')]));
    }
}
