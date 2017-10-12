<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Modules\Workflow\Entities\WorkflowPriority;
use Modules\Workflow\Http\Requests\CreateWorkflowPriorityRequest;
use Modules\Workflow\Http\Requests\UpdateWorkflowPriorityRequest;
use Modules\Workflow\Repositories\WorkflowPriorityRepository;
use Modules\Workflow\Repositories\RequestTypeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Workflow\Http\Requests\PriorityRequest;
use Modules\Workflow\Http\Requests\Updateworkflowpriority;
use Modules\User\Contracts\Authentication;
class WorkflowPriorityController extends AdminBaseController
{
    /**
     * @var WorkflowPriorityRepository
     */
    private $workflowpriority;
    /**
     * @var Authentication
     */
    private $auth;


    public function __construct(WorkflowPriorityRepository $workflowpriority,Authentication $auth)
    {
        parent::__construct();

        $this->workflowpriority = $workflowpriority;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $workflowpriorities = $this->workflowpriority->all();
        $requestworkflow = app('Modules\Workflow\Repositories\RequestTypeRepository');
        $requesttypeflow = $requestworkflow->allWithColumns(['id','type'],'type');

        return view('workflow::admin.workflowpriorities.index', compact('requesttypeflow','workflowpriorities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('workflow::admin.workflowpriorities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWorkflowPriorityRequest $request
     * @return Response
     */
    public function store(CreateWorkflowPriorityRequest $request)
    {
        $data = [
            'priority'=> $request->priority,
            'sequence_no'=>$request->sequence_no,
            'css_class'=>$request->css_class,
            'task_default'=>$request->task_default,
            'request_type_id'=>$request->request_type_id,
            'created_by'=> $this->auth->user()->id
        ];
        $this->workflowpriority->create($data);
        $this->workflowpriority->create($request->all());

        return redirect()->route('admin.workflow.workflowpriority.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('workflow::workflowpriorities.title.workflowpriorities')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  WorkflowPriority $workflowpriority
     * @return Response
     */
    public function edit(WorkflowPriority $workflowpriority)
    {
        return view('workflow::admin.workflowpriorities.edit', compact('workflowpriority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WorkflowPriority $workflowpriority
     * @param  UpdateWorkflowPriorityRequest $request
     * @return Response
     */
    public function update(WorkflowPriority $workflowpriority, UpdateWorkflowPriorityRequest $request)
    {
        $workflowpriority = $this->workflowpriority->find($request->category_id);
        $data = [
            'priority'=> $request->priority,
            'sequence_no'=>$request->sequence_no,
            'css_class'=>$request->css_class,
            'task_default'=>$request->task_default,
        ];
        $this->workflowpriority->update($workflowpriority,$data);

        return redirect()->route('admin.workflow.workflowpriority.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('workflow::workflowpriorities.title.workflowpriorities')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  WorkflowPriority $workflowpriority
     * @return Response
     */
    public function destroy(WorkflowPriority $workflowpriority)
    {
        $this->workflowpriority->destroy($workflowpriority);

        return redirect()->route('admin.workflow.workflowpriority.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('workflow::workflowpriorities.title.workflowpriorities')]));
    }
}
