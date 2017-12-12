<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Workflow\Entities\WorkflowSequence;
use Modules\Workflow\Http\Requests\CreateWorkflowSequenceRequest;
use Modules\Workflow\Http\Requests\UpdateWorkflowSequenceRequest;
use Modules\Workflow\Repositories\WorkflowSequenceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class WorkflowSequenceController extends AdminBaseController
{
    /**
     * @var WorkflowSequenceRepository
     */
    private $workflowsequence;

    public function __construct(WorkflowSequenceRepository $workflowsequence)
    {
        parent::__construct();

        $this->workflowsequence = $workflowsequence;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$workflowsequences = $this->workflowsequence->all();

        return view('workflow::admin.workflowsequences.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('workflow::admin.workflowsequences.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWorkflowSequenceRequest $request
     * @return Response
     */
    public function store(CreateWorkflowSequenceRequest $request)
    {
        $this->workflowsequence->create($request->all());

        return redirect()->route('admin.workflow.workflowsequence.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('workflow::workflowsequences.title.workflowsequences')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  WorkflowSequence $workflowsequence
     * @return Response
     */
    public function edit(WorkflowSequence $workflowsequence)
    {
        return view('workflow::admin.workflowsequences.edit', compact('workflowsequence'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WorkflowSequence $workflowsequence
     * @param  UpdateWorkflowSequenceRequest $request
     * @return Response
     */
    public function update(WorkflowSequence $workflowsequence, UpdateWorkflowSequenceRequest $request)
    {
        $this->workflowsequence->update($workflowsequence, $request->all());

        return redirect()->route('admin.workflow.workflowsequence.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('workflow::workflowsequences.title.workflowsequences')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  WorkflowSequence $workflowsequence
     * @return Response
     */
    public function destroy(WorkflowSequence $workflowsequence)
    {
        $this->workflowsequence->destroy($workflowsequence);

        return redirect()->route('admin.workflow.workflowsequence.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('workflow::workflowsequences.title.workflowsequences')]));
    }
}
