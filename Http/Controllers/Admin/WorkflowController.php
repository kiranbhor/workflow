<?php

namespace Modules\Workflow\Http\Controllers\Admin;

use App\Exceptions\ActionNotAllowedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Modules\Workflow\Entities\Workflow;
use Modules\Workflow\Http\Requests\CreateWorkflowRequest;
use Modules\Workflow\Http\Requests\UpdateWorkflowRequest;
use Modules\Workflow\Repositories\WorkflowRepository;



class WorkflowController extends AdminBaseController
{
    /**
     * @var WorkflowRepository
     */
    private $workflow;

    /**
     * @var Authentication
     */
    private $auth;


    public function __construct(WorkflowRepository $workflow, Authentication $auth)
    {
        parent::__construct();

        $this->workflow = $workflow;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $workflows = $this->workflow
            ->getUserRequests($this->auth->user()->id, ['assignedBy', 'requestType', 'status']);

        return view('workflow::admin.workflows.index', compact('workflows'));
    }
    
     /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAssignedRequests()
    {
        $requestTypes = app(getRepoName('RequestType','Workflow'))->all();
        return view('workflow::admin.workflows.assignedrequests',compact('requestTypes'));
    }

    /**
     * @param $workflowId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function getRequestDetails($workflowId)
    {
        try {
            $userId = $this->auth->user()->id;
            $objWorkflow = $this->workflow->findWith($workflowId, ['requestType']);
            $data = $this->workflow->getRequestData($objWorkflow);
            return view('workflow::partials.requests.' . $objWorkflow->requestType->details_view, compact('objWorkflow', 'data', 'userId'));
        } catch (\Exception $ex) {
            throw $ex;
            response()->view('core::partials.error', ['message' => trans('core::errors.messages.something went wrong', ['operation' => 'getting request information'])], 500);
        }
    }

    /**
     * Show the form for creating a new workflow sequence #TODO entire workflow design creation to use.
     *
     * @return Response
     */
    public function create()
    {
        $this->workflow
            ->createRequest($this->auth->user(), 5, 1, 'Test', 'Request Test', ['name' => 'test'], 1, null);
        return view('workflow::admin.workflows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWorkflowRequest $request
     * @return Response
     */
    public function store(CreateWorkflowRequest $request)
    {
        $this->workflow->create($request->all());

        return redirect()->route('admin.workflow.workflow.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('workflow::workflows.title.workflows')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Workflow $workflow
     * @return Response
     */
    public function edit(Workflow $workflow)
    {
        return view('workflow::admin.workflows.edit', compact('workflow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Workflow $workflow
     * @param  UpdateWorkflowRequest $request
     * @return Response
     */
    public function update(Workflow $workflow, UpdateWorkflowRequest $request)
    {
        $this->workflow->update($workflow, $request->all());

        return redirect()->route('admin.workflow.workflow.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('workflow::workflows.title.workflows')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Workflow $workflow
     * @return Response
     */
    public function destroy(Workflow $workflow)
    {
        $this->workflow->destroy($workflow);

        return redirect()->route('admin.workflow.workflow.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('workflow::workflows.title.workflows')]));
    }

    /**
     * Approved the workflow
     * @param Request $request
     * @return mixed
     */
    public function postApproveRequest(Request $request)
    {
        $ids = array();

        try {

            $userNote = $request->user_note;
            $userId = $this->auth->user()->id;


            DB::beginTransaction();


            foreach ($request->workflow_id_selected as $approvalRequestId) {
                $workflow = $this->workflow->find($approvalRequestId);

                if ($workflow != null) {
                    if ($workflow->assigned_to_user_id != $userId) {
                        throw ActionNotAllowedException("You are not allowd to approve the request");
                    }

                    $workflow->supervisor_note = $userNote;
                    $workflow->save();

                    if ($this->workflow->approveWorkflow($workflow) != true) {
                        throw \Exception('Something went wrong please try again later');
                    }
                }
                array_push($ids, $approvalRequestId);
            }

            ##TODO Notify Approval

            DB::commit();

            return redirect()->back()
                ->withSuccess('Selected requests approved successfully');


        } catch (ActionNotAllowedException $ex) {
            DB::rollback();
            return redirect()->back()
                ->withError($ex->getMessage());
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                ->withError(trans('core::errors.messages.something went wrong', ['operation' => 'approving request']));

        }


    }


    /**
     * Rejects multiple workflow
     * @param Request $request
     * @return mixed
     */
    public function postRejectRequest(Request $request)
    {
        $ids = array();

        try {

            $userNote = $request->user_note;
            $userId = $this->auth->user()->id;


            DB::beginTransaction();


            foreach ($request->workflow_id_selected as $approvalRequestId) {

                $workflow = $this->workflow->find($approvalRequestId);

                if ($workflow != null) {
                    if ($workflow->assigned_to_user_id != $userId) {
                        throw ActionNotAllowedException("You are not allowd to reject the request");
                    }

                    $workflow->supervisor_note = $userNote;
                    $workflow->save();

                    if ($this->workflow->rejectWorkflow($workflow) != true) {
                        throw \Exception('Something went wrong please try again later');
                    }
                }
                array_push($ids, $approvalRequestId);
            }

            ##TODO Notify Approval

            DB:
            commit();

            return redirect()->back()
                ->withSuccess('Selected requests rejected successfully');

        } catch (ActionNotAllowedException $ex) {
            DB::rollback();
            return redirect()->back()
                ->withError($ex->getMessage());
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                ->withError(trans('core::errors.messages.something went wrong', ['operation' => 'rejecting request']));

        }
    }

    /**
     * Cancels the request
     * @param Request $request
     * @return mixed
     */
    public function postCancelRequest(Request $request)
    {
        $ids = array();

        try {

            $userNote = $request->user_note;
            $userId = $this->auth->user()->id;


            DB::beginTransaction();


            foreach ($request->workflow_id_selected as $approvalRequestId) {
                $workflow = $this->workflow->find($approvalRequestId);

                if ($workflow != null) {
                    if ($workflow->requester_id != $userId) {
                        throw ActionNotAllowedException("You are not allowd to approve the request");
                    }

                    $workflow->user_note = $userNote;
                    $workflow->save();

                    if ($this->workflow->cancelWorkflow($workflow) != true) {
                        throw \Exception('Something went wrong please try again later');
                    }
                }
                array_push($ids, $approvalRequestId);
            }

            ##TODO Notify Approval

            DB::commit();

            return redirect()->back()
                ->withSuccess('Selected requests approved successfully');


        } catch (ActionNotAllowedException $ex) {
            DB::rollback();
            return redirect()->back()
                ->withError($ex->getMessage());
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                ->withError(trans('core::errors.messages.something went wrong', ['operation' => 'canceling request']));

        }
    }

    /**
     * Forward the request to specified user
     * @return [type] [description]
     */
    public function postForwardRequest(Request $request)
    {

        $ids = array();

        try {


            $userNote = $request->user_note;
            $toUserId = $request->forward_user_id;

            $userId = $this->auth->user()->id;
            $userRepo = app('Modules\User\Repositories\UserRepository');

            foreach ($request->workflow_id_selected as $workflowId) {

                $workflow = $this->workflow->find($workflowId);
                if ($workflow != null) {
                    if ($workflow->assigned_to_user_id != $userId) {
                        throw ActionNotAllowedException("You are not authorised to forward the request");
                    }

                    $workflow->supervisor_note = $userNote;
                    $workflow->save();

                    $fromUser = $userRepo->find($this->auth->user()->id);
                    $toUser = $userRepo->find($toUserId);

                    if ($this->workflow->forwardWorkflow($workflow, $fromUser, $toUser, null, null, $workflow->request_type_id) == true) {
                        if (count($request->workflow_id_selected) == 1) {
                            if ($request->ajax()) {
                                return Response::json(['success' => true, 'message' => 'Request is forwarded.', 'workflow' => $workflow]); //added by Neethu to return json response for reject request success
                            } else {
                                flash()->success('Request is forwarded');
                            }
                        }
                    } else {
                        if ($request->ajax()) {
                            return Response::json(['success' => false, 'message' => 'Error occured forwarding request. please contact support.']); //added by Neethu to return json response for reject request failure
                        } else {
                            flash()->success('Error occured forwarding request. please contact support');
                        }
                    }

                }
            }

            array_push($ids, $workflowId);

            $workflows = $this->workflow->findByMany($ids);
            return Response::json(['success' => true, 'message' => 'Request Forwarded Successfully.', 'workflows' => $workflows]);
        } catch (ActionNotAllowedException $ex) {
            DB::rollback();
            return redirect()->back()
                ->withError($ex->getMessage());
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                ->withError(trans('core::errors.messages.something went wrong', ['operation' => 'canceling request']));

        }

    }


}
