<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
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

    public function __construct(WorkflowStatusRepository $workflowstatus)
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
        return view('workflow::admin.workflowstatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWorkflowStatusRequest $request
     * @return Response
     */
    public function store(CreateWorkflowStatusRequest $request)
    {
        $data = [
            'status'=> $request->status,
            'sequence_no'=>$request->sequence_no,
            'label_class'=>$request->label_class,
            'is_closing_status'=>$request->is_closing_status,
            'request_type_id'=>$request->request_type_id,
            'created_by'=> $this->auth->user()->id
        ];
        $this->workflowstatus->create($data);
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
        return view('workflow::admin.workflowstatuses.edit', compact('workflowstatus'));
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
        $workflowstatus = $this->workflowstatus->find($request->category_id);
        $data = [
            'status'=> $request->status,
            'sequence_no'=>$request->sequence_no,
            'label_class'=>$request->label_class,
            'is_closing_status'=>$request->is_closing_status,
        ];
        $this->workflowstatus->update($workflowstatus, $data);

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
