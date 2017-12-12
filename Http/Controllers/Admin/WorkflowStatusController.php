<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Modules\Master\Repositories\DepartmentRepository;
use Modules\Master\Repositories\DesignationRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Workflow\Entities\WorkflowStatus;
use Modules\Workflow\Http\Requests\CreateWorkflowStatusRequest;
use Modules\Workflow\Http\Requests\UpdateWorkflowStatusRequest;
use Modules\Workflow\Repositories\WorkflowStatusRepository;
use Modules\Workflow\Repositories\RequestTypeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Workflow\Http\Requests\Statusrequest;
use Modules\Workflow\Http\Requests\UpdatestatusRequest;
use Modules\User\Contracts\Authentication;
class WorkflowStatusController extends AdminBaseController
{
    /**
     * @var WorkflowStatusRepository
     */
    private $workflowstatus;
    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(WorkflowStatusRepository $workflowstatus,Authentication $auth)
    {
        parent::__construct();

        $this->workflowstatus = $workflowstatus;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $workflowstatuses = $this->workflowstatus->all();
        $requeststatusworkflow = app('Modules\Workflow\Repositories\RequestTypeRepository');
        $requeststatusflow = $requeststatusworkflow->allWithColumns(['id','type'],'type');
        return view('workflow::admin.workflowstatuses.index', compact('requeststatusflow','workflowstatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $requestTypes = app(RequestTypeRepository::class)->allWithBuilder()
            ->orderBy('type')
            ->pluck('type','id');

        $employees = app(UserRepository::class)->all()
            ->where('user_type_id','=',EMPLOYEE_USER_TYPE)
            ->pluck('first_name','id');

        $departments = app(DepartmentRepository::class)->allWithBuilder()
            ->orderBy('name')
            ->pluck('name','id');

        $designations = app(DesignationRepository::class)->allWithBuilder()
            ->orderBy('designation')
            ->pluck('designation','id');

        $data = [
           'requestTypes' => $requestTypes,
           'employees' => $employees,
           'departments' => $departments,
           'designations' => $designations
        ];


        return view('workflow::admin.workflowstatuses.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWorkflowStatusRequest $request
     * @return Response
     */
    public function store(CreateWorkflowStatusRequest $request)
    {

        $this->workflowstatus->create($request->all());

        return redirect()->route('admin.workflow.workflowstatus.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('workflow::workflowstatuses.title.workflowstatuses')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  WorkflowStatus $workflowstatus
     * @return Response
     */
    public function edit(WorkflowStatus $workflowstatus)
    {
        $requestTypes = app(RequestTypeRepository::class)->allWithBuilder()
            ->orderBy('type')
            ->pluck('type','id');

        $employees = app(UserRepository::class)->all()
            ->where('user_type_id','=',EMPLOYEE_USER_TYPE)
            ->pluck('first_name','id');

        $departments = app(DepartmentRepository::class)->allWithBuilder()
            ->orderBy('name')
            ->pluck('name','id');

        $designations = app(DesignationRepository::class)->allWithBuilder()
            ->orderBy('designation')
            ->pluck('designation','id');

        $data = [
            'requestTypes' => $requestTypes,
            'employees' => $employees,
            'departments' => $departments,
            'designations' => $designations,
            'workflowstatus' => $workflowstatus
        ];
        return view('workflow::admin.workflowstatuses.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WorkflowStatus $workflowstatus
     * @param  UpdateWorkflowStatusRequest $request
     * @return Response
     */
    public function update(WorkflowStatus $workflowstatus, UpdateWorkflowStatusRequest $request)
    {
        $this->workflowstatus->update($workflowstatus, $request->all());

        return redirect()->route('admin.workflow.workflowstatus.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('workflow::workflowstatuses.title.workflowstatuses')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  WorkflowStatus $workflowstatus
     * @return Response
     */
    public function destroy(WorkflowStatus $workflowstatus)
    {
        $this->workflowstatus->destroy($workflowstatus);

        return redirect()->route('admin.workflow.workflowstatus.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('workflow::workflowstatuses.title.workflowstatuses')]));
    }
}
