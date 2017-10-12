<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Modules\Workflow\Entities\RequestType;
use Modules\Workflow\Http\Requests\CreateRequestTypeRequest;
use Modules\Workflow\Http\Requests\UpdateRequestTypeRequest;
use Modules\Workflow\Repositories\RequestTypeRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Profile\Repositories\DesignationRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Illuminate\Support\Facades\Log;

class RequestTypeController extends AdminBaseController
{
    /**
     * @var RequestTypeRepository
     */
    private $requesttype;
    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(RequestTypeRepository $requesttype,Authentication $auth)
    {
        parent::__construct();

        $this->requesttype = $requesttype;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $requesttypes = $this->requesttype->all();
        $requestuser = app('Modules\User\Repositories\UserRepository');
        $designation = app('Modules\Profile\Repositories\DesignationRepository');
        $requestuserid = $requestuser->all(['id','first_name'],'first_name');
        $profiledesignation =$designation->all('id','designation');

        return view('workflow::admin.requesttypes.index', compact('requestuserid','requesttypes','profiledesignation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('workflow::admin.requesttypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequestTypeRequest $request
     * @return Response
     */
    public function store(CreateRequestTypeRequest $request)
    {
        $data = [
            'type' =>$request->type,
            'parent_request_id' =>$request->parent_request_id,
            'sequence_no' =>$request->sequence_no,
            'description' =>$request->description,
            'send_email_notification' =>$request->send_email_notification,
            'default_assignee_user_id' =>$request->default_assignee_user_id,
            'default_designation_id' =>$request->default_designation_id,
            'default_dept_id' =>$request->default_dept_id,
            'notification_group_id' =>$request->notification_group_id,
            'closing_status_ids' =>$request->closing_status_ids,
            'validity_days' =>$request->validity_days,
            'additional_emails_to_notify' =>$request->additional_emails_to_notify,
            'notify_to_supervisor' =>$request->notify_to_supervisor,
            'initial_request_status_id' =>$request->initial_request_status_id,
            'assign_to_supervisor' =>$request->assign_to_supervisor,
            'update_request_route' =>$request->update_request_route,
            'create_request_route' =>$request->create_request_route,
            'repository' =>$request->repository,
            'created_by'=> $this->auth->user()->id
        ];
        $this->requesttype->create($data);

        return redirect()->route('admin.workflow.requesttype.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('workflow::requesttypes.title.requesttypes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  RequestType $requesttype
     * @return Response
     */
    public function edit(RequestType $requesttype)
    {
        return view('workflow::admin.requesttypes.edit', compact('requesttype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RequestType $requesttype
     * @param  UpdateRequestTypeRequest $request
     * @return Response
     */
    public function update(RequestType $requesttype, UpdateRequestTypeRequest $request)
    {
        $requesttype = $this->requesttype->find($request->category_id);
        $data = [
            'type' =>$request->type,
            'parent_request_id' =>$request->parent_request_id,
            'sequence_no' =>$request->sequence_no,
            'description' =>$request->description,
            'send_email_notification' =>$request->send_email_notification,
            'notification_group_id' =>$request->notification_group_id,
            'closing_status_ids' =>$request->closing_status_ids,
            'validity_days' =>$request->validity_days,
            'additional_emails_to_notify' =>$request->additional_emails_to_notify,
            'notify_to_supervisor' =>$request->notify_to_supervisor,
            'initial_request_status_id' =>$request->initial_request_status_id,
            'assign_to_supervisor' =>$request->assign_to_supervisor,
            'update_request_route' =>$request->update_request_route,
            'create_request_route' =>$request->create_request_route,
            'repository' =>$request->repository


        ];
        $this->requesttype->update($requesttype, $data);

        return redirect()->route('admin.workflow.requesttype.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('workflow::requesttypes.title.requesttypes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  RequestType $requesttype
     * @return Response
     */
    public function destroy(RequestType $requesttype)
    {
        $this->requesttype->destroy($requesttype);

        return redirect()->route('admin.workflow.requesttype.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('workflow::requesttypes.title.requesttypes')]));
    }
}
