<?php

namespace Modules\Workflow\Http\Controllers\Admin;


use Illuminate\Http\Response;
use Modules\Master\Repositories\DepartmentRepository;
use Modules\Master\Repositories\DesignationRepository;
use Modules\Workflow\Entities\RequestType;
use Modules\Workflow\Http\Requests\CreateRequestTypeRequest;
use Modules\Workflow\Http\Requests\UpdateRequestTypeRequest;
use Modules\Workflow\Repositories\RequestTypeRepository;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Modules\Workflow\Repositories\WorkflowStatusRepository;


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

        $profiledesignation = app('Modules\Master\Repositories\DesignationRepository')->all('id','designation');

        $requestuserid =  app('Modules\User\Repositories\UserRepository')
            ->all(['id','first_name'],'first_name');


        return view('workflow::admin.requesttypes.index', compact('requestuserid','requesttypes','profiledesignation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $requestTypes = $this->requesttype->allWithBuilder()
            ->orderby('type')
            ->pluck('type','id');

        $departments = app(DepartmentRepository::class)->allWithBuilder()
            ->orderBy('name')
            ->pluck('name','id');

        $designations = app(DesignationRepository::class)->allWithBuilder()
            ->orderBy('designation')
            ->pluck('designation','id');

        $requestStatus = app(WorkflowStatusRepository::class)->allWithBuilder()
            ->orderBy('status')
            ->pluck('status','id');


        $data = [
            'requestTypes' => $requestTypes,
            'departments' => $departments,
            'designations' => $designations,
            'requestStatus' => $requestStatus
        ];



        return view('workflow::admin.requesttypes.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequestTypeRequest $request
     * @return Response
     */
    public function store(CreateRequestTypeRequest $request)
    {
        $this->requesttype->createNew($request->all());

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
        $requestTypes = $this->requesttype->allWithBuilder()
            ->orderby('type')
            ->pluck('type','id');

        $departments = app(DepartmentRepository::class)->allWithBuilder()
            ->orderBy('name')
            ->pluck('name','id');

        $designations = app(DesignationRepository::class)->allWithBuilder()
            ->orderBy('designation')
            ->pluck('designation','id');

        $requestStatus = app(WorkflowStatusRepository::class)->allWithBuilder()
            ->orderBy('status')
            ->pluck('status','id');


        $data = [
            'requestTypes' => $requestTypes,
            'departments' => $departments,
            'designations' => $designations,
            'requestStatus' => $requestStatus,
            'requesttype' => $requesttype
        ];



        return view('workflow::admin.requesttypes.edit', $data);
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

        $this->requesttype->updateRequestType($requesttype, $request->all());

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
