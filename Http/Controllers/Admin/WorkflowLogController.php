<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Workflow\Entities\WorkflowLog;
use Modules\Workflow\Http\Requests\CreateWorkflowLogRequest;
use Modules\Workflow\Http\Requests\UpdateWorkflowLogRequest;
use Modules\Workflow\Repositories\WorkflowLogRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class WorkflowLogController extends AdminBaseController
{
    /**
     * @var WorkflowLogRepository
     */
    private $workflowlog;

    public function __construct(WorkflowLogRepository $workflowlog)
    {
        parent::__construct();

        $this->workflowlog = $workflowlog;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$workflowlogs = $this->workflowlog->all();

        return view('workflow::admin.workflowlogs.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('workflow::admin.workflowlogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWorkflowLogRequest $request
     * @return Response
     */
    public function store(CreateWorkflowLogRequest $request)
    {
        $this->workflowlog->create($request->all());

        return redirect()->route('admin.workflow.workflowlog.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('workflow::workflowlogs.title.workflowlogs')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  WorkflowLog $workflowlog
     * @return Response
     */
    public function edit(WorkflowLog $workflowlog)
    {
        return view('workflow::admin.workflowlogs.edit', compact('workflowlog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WorkflowLog $workflowlog
     * @param  UpdateWorkflowLogRequest $request
     * @return Response
     */
    public function update(WorkflowLog $workflowlog, UpdateWorkflowLogRequest $request)
    {
        $this->workflowlog->update($workflowlog, $request->all());

        return redirect()->route('admin.workflow.workflowlog.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('workflow::workflowlogs.title.workflowlogs')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  WorkflowLog $workflowlog
     * @return Response
     */
    public function destroy(WorkflowLog $workflowlog)
    {
        $this->workflowlog->destroy($workflowlog);

        return redirect()->route('admin.workflow.workflowlog.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('workflow::workflowlogs.title.workflowlogs')]));
    }

    /**
     * View logs for workflow
     * @param $workflowId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewRequestLog($workflowId) {
        $workflowlogs = $this->workflowlog->findManyByWith(['request_workflow_id' => $workflowId], ['toStatus', 'toUser'], 'created_at');
        return view('workflow::admin.workflowlogs.index', compact('workflowlogs'));
    }
}
