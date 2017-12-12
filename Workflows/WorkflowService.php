<?php


namespace Modules\Workflow\Workflows;

use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Support\Facades\Log;
use Modules\User\Http\Middleware\LoggedInMiddleware;
use Modules\Workflow\Repositories\RequestTypeRepository;
use Modules\Workflow\Repositories\WorkflowLogRepository;
use Modules\Workflow\Repositories\WorkflowRepository;
use Modules\Workflow\Repositories\WorkflowStatusRepository;
use Workflow;

class WorkflowService
{

    /**
     * Get transitions that can be applied to workflow
     *
     * @param $workflow
     * @return array
     */
    public static function getWorkflowTransitions($workflow)
    {
        $workflowSeq = Workflow::get($workflow,$workflow->requestType->type);
        $transitions = $workflowSeq->getEnabledTransitions($workflow);
        $allowdTransitions = [];

        foreach ($transitions as $transition){
            $info = [
                'html' => trans('workflow::workflows.'.$workflow->requestType . '.'.$transition->getName().'.html'),
                'text' => trans('workflow::workflows.'.$workflow->requestType . '.'.$transition->getName().'.text'),
                'name' => $transition->getName()
            ];
            array_push($allowdTransitions,$info);
        }
        return $allowdTransitions;
    }

    /**
     * Gets workflow for the given worflow object
     * @param $workflow
     * @return \Symfony\Component\Workflow\Workflow
     */
    public static function getWorkflowSequence($workflow){
        $workflowSeq = Workflow::get($workflow,$workflow->requestType->type);

        return $workflowSeq;
    }

    /**
     * Apply given transition to workflow
     * @param $workflow
     * @param $transition
     * @param $workflowStatus
     */
    public static function applyTransition($workflow,$transition,$workflowStatus){

        $workflow->request_workflow_status_id = $workflowStatus->id;
        $workflow->request_status_id = $workflowStatus->id;

        $workflow->assigned_to_user_id = $workflowStatus->assign_to_employee;
        $workflow->assigned_to_designation_id = $workflowStatus->assign_to_designation;
        $workflow->assigned_to_department_id = $workflowStatus->assign_to_department;
        $workflow->requester_id = auth()->user()->id;

        //Create workflowlog

        $workflowLog = [
            'request_workflow_id' => $workflow->id,
            'from_request_status_id' => $workflow->getOriginal('request_workflow_status_id'),
            'to_request_status_id' => $workflow->request_workflow_status_id,
            'from_emp_id' => $workflow->getOriginal('assigned_to_user_id'),
            'to_emp_id' => $workflow->assigned_to_user_id,
            'from_department_id' =>  $workflow->getOriginal('assigned_to_department_id'),
            'to_department_id' =>   $workflow->assigned_to_department_id ,
            'from_designation_id'=>$workflow->getOriginal('assigned_to_designation_id'),
            'to_designation_id' => $workflow->assigned_to_designation_id,
            'log_date' => Carbon::now(),
            'action' => $transition->getName(),
            'supervisor_comment' => ($workflow->supervisor_note != null) ? $workflow->supervisor_note : '',
            'is_closed' => isset($workflowStatus->is_closing_status)?$workflowStatus->is_closing_status:false
        ];

        app(WorkflowLogRepository::class)->create($workflowLog);
    }


    /**
     * Get all transitions in workflow
     */
    public static function getRegisteredTransitions($type){

        $workflowObject =  new \Modules\Workflow\Entities\Workflow();
        $allTransitions = [];

        try{
            $workflowSeq = Workflow::get($workflowObject,$type);
            $transitions = $workflowSeq->getDefinition()->getTransitions();
            foreach ($transitions as $transition){
                $info = [
                    'html' => trans('workflow::workflows.'.$type . '.'.$transition->getName().'.html'),
                    'text' => trans('workflow::workflows.'.$type . '.'.$transition->getName().'.text'),
                    'name' => $transition->getName(),
                    'full_name' => $type. ': '.  trans('workflow::workflows.'.$type . '.'.$transition->getName().'.text')
                ];
                array_push($allTransitions,$info);
            }
        }
        catch(\Exception $ex){
            Log::info("Workflow ". $type." not found in worklfow repo");
        }

        return $allTransitions;

    }


    /**
     * Get all transitions in workflow
     */
    public static function getAllRegisteredTransitions(){

        $workflowObject =  new \Modules\Workflow\Entities\Workflow();
        $allTransitions = [];

        $workflows =  app(RequestTypeRepository::class)->all();

        foreach ($workflows as $workflow){
            try{
                $workflowSeq = Workflow::get($workflowObject,$workflow->type);
                $transitions = $workflowSeq->getDefinition()->getTransitions();
                foreach ($transitions as $transition){
                    $info = [
                        'html' => trans('workflow::workflows.'.$workflow->type . '.'.$transition->getName().'.html'),
                        'text' => trans('workflow::workflows.'.$workflow->type . '.'.$transition->getName().'.text'),
                        'name' => $transition->getName(),
                        'full_name' => $workflow->type. ': '.  trans('workflow::workflows.'.$workflow->type . '.'.$transition->getName().'.text')
                    ];
                    array_push($allTransitions,$info);
                }
            }
            catch(\Exception $ex){
                Log::info("Workflow ". $workflow->type." not found in worklfow repo");
            }
        }

        return $allTransitions;

    }


}
