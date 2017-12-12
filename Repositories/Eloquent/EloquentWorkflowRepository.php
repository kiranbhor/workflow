<?php

namespace Modules\Workflow\Repositories\Eloquent;

use App\Exceptions\CustomErrorException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Master\Repositories\EmployeeRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Workflow\Entities\Workflow;
use Modules\Workflow\Repositories\RequestTypeRepository;
use Modules\Workflow\Repositories\WorkflowLogRepository;
use Modules\Workflow\Repositories\WorkflowRepository;
use DataTables;
use Modules\Workflow\Workflows\WorkflowService;

class EloquentWorkflowRepository extends EloquentBaseRepository implements WorkflowRepository
{

    /**
     * Creates new Workflow
     * @param $assignedBy
     * @param $requestTypeId
     * @param $refRequestId
     * @param $userNote
     * @param $requestText
     * @param $requestData
     * @param $assignedTo
     * @param null $statusId
     * @return mixed
     * @throws \Exception
     */
    public function createRequest($assignedBy, $requestTypeId, $refRequestId, $userNote, $requestText, $requestData, $assignedTo = null, $statusId = null)
    {
        try {

            $requestType = app(RequestTypeRepository::class)->find($requestTypeId);

            $workflow = new Workflow();

            $workflow->request_type_id = $requestType->id;
            $workflow->request_ref_id = $refRequestId;

            if($statusId === null){
                $workflow->request_status_id = $requestType->initial_request_status_id;
            }
            else{
                $workflow->request_status_id = $statusId;
            }

            if($assignedTo === null){
                $workflow->assigned_to_user_id = $requestType->default_assignee_user_id;
            }
            else{
                $workflow->assigned_to_user_id = $assignedTo->id;
            }

            if($workflow->assigned_to_user_id === null){
                $workflow->assigned_to_designation_id = $requestType->default_designation_id;
            }

            if($workflow->assigned_to_designation_id === null){
                $workflow->assigned_to_department_id = $requestType->default_dept_id;
            }

            $workflow->requester_id = $assignedBy->id;
            $workflow->request_workflow_status_id = ($statusId === null)?$requestType->initial_request_status_id:$statusId;
            $workflow->request_date = Carbon::now();
            $workflow->is_expired = false;
            $workflow->user_note =  $userNote;
            $workflow->supervisor_note = "";
            $workflow->request_text = $requestText;
            $workflow->datetime_added = Carbon::now();
            $workflow->is_open = true;
            $workflow->request_data = json_encode($requestData);
            $workflow->assignee_comment = "";
            $workflow->created_by = auth()->user()->id;

            $workflow->save();

           // $WorkflowObj = Workflow::get($workflow, $requestType->type);


            return $workflow;


        } catch (\Exception $ex) {
            throw $ex;
        }

    }

    /**
     * Updates workflow
     * @param $workflow
     * @param $requestStatus
     * @param $isOpen
     * @param null $userNote
     * @param null $requestText
     * @param null $requestData
     * @return bool
     * @throws \Exception
     */
    public function updateWorkflow($workflow, $requestStatus, $isOpen,$userNote = null,$requestText = null,$requestData = null )
    {

        try {
            $workflowLog = [
                'request_workflow_id' => $workflow->id,
                'from_request_status_id' => $workflow->request_workflow_status_id,
                'to_request_status_id' => $requestStatus,
                'from_emp_id' => $workflow->assigned_to_user_id,
                'to_emp_id' => $workflow->requester_id,
                'log_date' => Carbon::now(),
                'action' => 'Request Updated',
                'supervisor_comment' => 'Workflow updated',
                'is_closed' => true,
            ];

            //Create new log
            app(WorkflowLogRepository::class)->create($workflowLog);
            $notificationRepo = app('Modules\Workflow\Repositories\NotificationRepository');

            //update workflow
            $workflow->request_workflow_status_id = $requestStatus;
            $workflow->request_status_id = $requestStatus;
            $workflow->is_open = $isOpen;

            if($requestText !== null){
                $workflow->request_text = $requestText;
            }

            if($userNote !== null){
                $workflow->user_note = $userNote;
            }

            if($requestData != null){
                $workflow->request_data = $requestData;
            }

            $workflow->save();

            return true;

        } catch (\Exception $ex) {
            throw  $ex;
        }
    }

    /**
     * Get requests created by user in given duration
     * @param $user
     * @param $fromDate
     * @param $toDate
     * @param $requetTypeId
     * @param bool $considerRejected
     * @return mixed
     * @throws \Exception
     */
    public function getLatestRequestByUser($user, $fromDate, $toDate, $requetTypeId, $considerRejected = true)
    {

        try {

            $query = $this->model->where('requester_id', '=', $user->id)
                ->where('request_type_id', '=', $requetTypeId)
                ->whereBetween('request_date', [$fromDate->format('Y-m-d'), $toDate->format('Y-m-d')]);

            if ($considerRejected == false) {
                $query = $query->where('request_status_id', '<>', Config('asgard.workflow.config.request_status.rejected'));
            }

            return $query->orderBy('request_date', 'desc')->first();

        } catch (\Exception $ex) {
            throw $ex;
        }

    }

    /**
     * Returns if request is approved
     * @param $workflowId
     * @return bool
     * @throws \Exception
     */
    public function isApproved($workflowId)
    {
        try {
            $objWorkflow = $this->find($workflowId);
            return ($objWorkflow->request_workflow_status_id == STATUS_APPROVED);

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Returns if workflow is rejected
     * @param $workflowId
     * @return bool
     * @throws \Exception
     */
    public function isRejected($workflowId)
    {
        try {
            $objWorkflow = $this->find($workflowId);
            return ($objWorkflow->request_workflow_status_id == STATUS_REJECTED);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Get requests generated by user
     * @param $userId
     * @param array $with
     * @param int $noOfRequests
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     * @throws \Exception
     */
    public function getUserRequests($userId, $with = [], $noOfRequests = 10)
    {
        try {
            return $this->model->with($with)
                ->where('requester_id', '=', $userId)
                ->with($with)
                ->orderBy('datetime_added', 'desc')
                ->take($noOfRequests)
                ->get();

        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Delete given workflow ids
     * @param $workflowIds
     * @return mixed
     * @throws \Exception
     */
    public function deleteSelected($workflowIds)
    {
        try {
            return $this->model->whereIn('id', $workflowIds)->delete();

        } catch (\Exception $ex) {
            throw $ex;
        }

    }


    /**
     * Returns data associated with request
     * @param $objWorkflow
     * @return mixed
     * @throws \Exception
     */
    public function getRequestData($objWorkflow)
    {
        try {
            return app(getRepoNameByArray($objWorkflow->requestType->repository))
                ->findByAttributes(['id' => $objWorkflow->request_ref_id]);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    /**
     * Returns workflows assigned to user
     * @param $userId
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     * @throws \Exception
     */
    public function getAssignedRequests($user, $with = [], $requestTypeIds, $noOfRecords = 10)
    {
        //Get all the requests assigned to user also check the requests in workflowlog as if forwarded to other user the current user will no be in workflow table)
        try {

            if($user->hasRoleId(ADMIN_USER_ROLE)){

                $query = $this->model->with($with)
                    ->where('is_open', '=', true)
                    ->orderBy('datetime_added', 'desc');
            }
            else{
                $employee = app(EmployeeRepository::class)->findByAttributes(['user_id'=>$user->id]);

                $query = $this->model->with($with)
                    ->where('is_open', '=', true)
                    ->where(function ($query) use ($employee) {
                        $query->whereIn('id', function ($query) use ($employee) {
                            $query->select(DB::raw('request_workflow_id'))
                                ->from('workflow__workflowlogs')->where('from_emp_id', '=', $employee->user_id)
                                ->orWhere('from_designation_id', '=', $employee->designation_id)
                                ->orWhere('from_department_id','=',$employee->department_id);
                        })
                            ->orWhere('assigned_to_user_id', '=', $employee->user_id)
                            ->orWhere(function($query) use($employee){
                                $query->whereNull('assigned_to_user_id')
                                    ->where('assigned_to_designation_id','=',$employee->designation_id);
                            })
                            ->orWhere(function($query) use($employee)    {
                                $query->whereNull('assigned_to_user_id')
                                    ->whereNull('assigned_to_designation_id')
                                    ->where('assigned_to_department_id','=',$employee->department_id);
                            });
                    })
                    ->orderBy('datetime_added', 'desc');
            }

            if (count($requestTypeIds) > 0) {
                $query = $query->whereIn('request_type_id', $requestTypeIds);
            }

            return Datatables::of($query)
                ->addColumn('chkbox',function ($workflow){
                    return '<input type="checkbox" name="ids[]" value="'. $workflow->id .'">';
                })
                ->addColumn('id', function ($workflow) {
                    return  $workflow->id;
                })
                ->addColumn('date',function($workflow){
                    return Carbon::parse($workflow->request_date)->format(PHP_DATE_FORMAT);

                })
                ->addColumn('assigned_by',function($workflow){
                    return $workflow->assignedBy->present()->fullname();
                })
                ->addColumn('type',function($workflow){
                    if($workflow->requestType->details_route !== null && $workflow->requestType->details_route !== ''){
                        return link_to_route($workflow->requestType->details_route,$workflow->requestType->type,$workflow->request_ref_id);
                    }
                    else{
                        return $workflow->requestType->type;
                    }

                })
                ->addColumn('status',function($workflow){
                    return $workflow->requestStatus->status;
                })
                ->addColumn('user_note',function($workflow){
                    return $workflow->user_note;
                })
                ->addColumn('request_text',function($workflow){
                    return htmlspecialchars_decode($workflow->request_text);
                })
                ->addColumn('assigned_to',function($workflow) {
                    if($workflow->assigned_to_user_id != null){
                        return $workflow->assigned_to->present()->fullname();
                    }
                    elseif ($workflow->assigned_to_designation_id != null){
                        return $workflow->assignedDesignation->designation;
                    }
                    else{
                        return $workflow->assignedDepartment->name . ' Department' ;
                    }
                })
                ->addColumn('actions',function($workflow) use($user) {
                    return WorkflowService::getWorkflowTransitions($workflow,$user);
                })
                ->rawColumns(['request_text','chkbox'])
                ->make(true);
        } catch (\Exception $ex) {
            throw  $ex;
        }
    }


    /**
     * Approve Workflow
     * @param $workflow
     * @return bool
     * @throws \Exception
     */
    public function approve($workflow)
    {
        try {
            $requestStatus = STATUS_APPROVED;

            if ($workflow->request_workflow_status_id != STATUS_APPROVED) {
                $requestType = app(getRepoName('RequestType', 'Workflow'))
                    ->find($workflow->request_type_id);

                //In case of calcelation request, the called approve function in the respective repository will check the request type
                //and call approve or cencel accordingly

                $approveRequest = app(getRepoNameByArray($requestType->repository))
                    ->approve($workflow->request_ref_id, $workflow);

                $workflowLog = [
                    'request_workflow_id' => $workflow->id,
                    'from_request_status_id' => $workflow->request_workflow_status_id,
                    'to_request_status_id' => $requestStatus,
                    'from_emp_id' => $workflow->assigned_to_user_id,
                    'to_emp_id' => $workflow->requester_id,
                    'log_date' => Carbon::now(),
                    'action' => 'Request Approved',
                    'supervisor_comment' => ($workflow->supervisor_note != null) ? $workflow->supervisor_note : '',
                    'is_closed' => true,
                ];

                //Create new log
                app(getRepoName('WorkflowLog', 'Workflow'))->create($workflowLog);

                //update workflow as approved
                $workflow->request_workflow_status_id = $requestStatus;
                $workflow->request_status_id = $requestStatus;
                $workflow->is_open = false;
                $workflow->save();

                return true;
            } else {
                throw new CustomErrorException("Requet is already approved");
            }

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Rejects the given request
     * @param $workflow
     * @return bool
     * @throws \Exception
     */
    public function reject($workflow)
    {
        try {

            if($workflow->request_workflow_status_id != STATUS_REJECTED) {

                $requestType = app(getRepoName('RequestType', 'Workflow'))
                    ->find($workflow->request_type_id);

                //Update leave status
                $updateLeaveStatus = app(getRepoNameByArray($requestType->repository))
                    ->reject($workflow->request_ref_id, $workflow->request_type_id);

                $workflowLog = [
                    'request_workflow_id' => $workflow->id,
                    'from_request_status_id' => $workflow->request_workflow_status_id,
                    'to_request_status_id' => STATUS_REJECTED,
                    'from_emp_id' => $workflow->assigned_to_user_id,
                    'to_emp_id' => $workflow->requester_id,
                    'request_workflow_status_id' => STATUS_REJECTED,
                    'log_date' => Carbon::now(),
                    'action' => 'Request Rejected',
                    'supervisor_comment' => $workflow->supervisor_note,
                    'is_closed' => true,
                ];

                //Create new log
                app(getRepoName('WorkflowLog', 'Workflow'))->create($workflowLog);

                //update workflow as rejected
                $workflow->request_workflow_status_id = STATUS_REJECTED;
                $workflow->request_status_id = STATUS_REJECTED;
                $workflow->is_open = false;
                $workflow->save();
                return true;
            }
            else{
                throw new CustomErrorException("Request is already rejected");
            }

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Cancels the given workflow
     * @param $workflow
     * @return bool
     * @throws \Exception
     */
    public function cancel($workflow)
    {

        try {

            if($workflow->request_workflow_status_id != STATUS_CANCELLED) {

                $requestType = app(getRepoName('RequestType', 'Workflow'))
                    ->find($workflow->request_type_id);

                //Update leave status
                $updateRequestStatus = app($requestType->repository)
                    ->cancel($workflow->request_ref_id, $workflow->request_type_id);

                $workflowLog = [
                    'request_workflow_id' => $workflow->id,
                    'from_request_status_id' => $workflow->request_workflow_status_id,
                    'to_request_status_id' => STATUS_CANCELLED,
                    'from_emp_id' => $workflow->assigned_to_user_id,
                    'request_workflow_status_id' => STATUS_CANCELLED,
                    'to_emp_id' => $workflow->requester_id,
                    'log_date' => Carbon::now(),
                    'action' => 'Request cancelled',
                    'supervisor_comment' => $workflow->supervisor_note,
                    'is_closed' => true,
                ];

                //Create new log
                app(getRepoName('WorkflowLog', 'Workflow'))->create($workflowLog);

                //update workflow as cancelled
                $workflow->request_workflow_status_id = STATUS_CANCELLED;
                $workflow->request_status_id = STATUS_CANCELLED;
                $workflow->is_open = false;
                $workflow->save();

                return true;
            }else{
                throw  new CustomErrorException("Status is already cancelled");
            }
        } catch (\Exception $ex) {
            throw  $ex;
        }
    }

    /**
     * Forwards the workflow
     * @param $workflow
     * @param $toUser
     * @param null $fromUser
     * @return bool
     * @throws \Exception
     */
    public function forward($workflow, $toUser, $fromUser = null)
    {
        try {

            $forwardedFromUserId = isset($fromUser->id) ? $fromUser->id : $workflow->assigned_to_user_id;

            $workflowLog = [
                'request_workflow_id' => $workflow->id,
                'from_request_status_id' => $workflow->request_workflow_status_id,
                'to_request_status_id' => STATUS_FORWARDED,
                'from_emp_id' => $forwardedFromUserId,
                'to_emp_id' => $toUser->id,
                'log_date' => Carbon::now(),
                'action' => 'Request Forwarded',
                'supervisor_comment' => ($workflow->supervisor_note != null) ? $workflow->supervisor_note : '',
                'is_closed' => false,
            ];

            //Create new log
            $Log = app(getRepoName('WorkflowLog', 'Workflow'))->create($workflowLog);

            //update workflow as approved
            $workflow->request_workflow_status_id = STATUS_FORWARDED;
            $workflow->request_status_id = STATUS_FORWARDED;
            $workflow->assigned_to_user_id = $toUser->id;
            $workflow->requester_id = $forwardedFromUserId;
            $workflow->save();

            return true;
        } catch (\Exception $ex) {
            throw  $ex;
        }
    }

    /**
     * Apply given transition on the Workflow
     * @param Workflow $workflow
     * @param $transition
     * @param string $userNote
     */
    public function applyTransition(Workflow $workflow,$transition,$userNote =  ""){
        $workflowSeq = WorkflowService::getWorkflowSequence($workflow);
        $workflowSeq->apply($workflow,$transition);
        $workflow->user_note =  $userNote;
        $workflow->save();
    }

    /**
     *  Apply given transition on the Workflow
     * @param $workflowIds
     * @param $transition
     * @param string $userNote
     * @return array
     */
    public function applyBulkTransition($workflowIds,$transition,$userNote =  ""){



        $workflows = $this->allWithBuilder()->whereIn('id',$workflowIds)->with(['requestType','assignedBy'])->get();

        $result =[];

        $count  = count($workflows);
        $counter = 0;

        session()->put('buklWorkflowId',$workflowIds);
        session()->put('bulkTransitionInProgress',true);
        session()->put('lastBulkTransition',false);

        foreach ($workflows as $workflow){
            $workflowSeq = WorkflowService::getWorkflowSequence($workflow);
            try{

                if (++$counter === $count){
                    session()->put('lastBulkTransition',true);
                }

                $workflowSeq->apply($workflow,$transition);
                $workflow->user_note =  $userNote;
                $workflow->save();

                array_push($result,[
                    'id'=>$workflow->id,
                    'request_type' => $workflow->requestType->type,
                    'success' => true,
                    'message' =>  trans('workflow::workflows.'.$workflow->requestType->type . '.'.$transition.'.text') .' successfull for '.$workflow->requestType->type.' id('. $workflow->request_ref_id .') from '. $workflow->assignedBy->present()->fullname() .' '. $transition . ' successfully'
                ]);
            }
            catch (\Exception $ex){
                array_push($result,[
                    'id'=>$workflow->id,
                    'request_type' => $workflow->requestType->type,
                    'success' => false,
                    'message' => 'Failed '. trans('workflow::workflows.'.$workflow->requestType->type . '.'.$transition.'.text').' for '.$workflow->requestType->type.' id('. $workflow->request_ref_id .') from '. $workflow->assignedBy->present()->fullname() .' '.$ex->getMessage()
                ]);
            }

        }

        session()->remove('buklWorkflowId');
        session()->remove('bulkTransitionInProgress');
        session()->remove('bulkLastTransition');


        return collect($result);
    }
}
