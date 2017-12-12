<?php

namespace Modules\Workflow\Events\Handlers;


use Brexis\LaravelWorkflow\Events\GuardEvent;
use Modules\Master\Repositories\EmployeeRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Workflow\Repositories\WorkflowStatusRepository;
use Modules\Workflow\Workflows\WorkflowService;
use Str;

class WorkflowSubscriber
{
    /**
     * Handle workflow guard events.
     */
    public function onGuard(GuardEvent $event) {

        /** Symfony\Component\Workflow\Event\GuardEvent */
        $originalEvent = $event->getOriginalEvent();
        $workflow = $originalEvent->getSubject();



        $user = auth()->user();
        $employee = app(EmployeeRepository::class)->findByAttributes(['user_id' => $user->id]);

        $fromStates = $originalEvent->getTransition()->getFroms();

        $workflowStates = app(WorkflowStatusRepository::class)->allWithBuilder()
            ->where('request_type_id','=',$workflow->request_type_id)
            ->whereIn('worklow_place',$fromStates)
            ->get();


        if($employee == null){
            $originalEvent->setBlocked(true);
            return false;
        }




        foreach ($workflowStates as $state){
            if(isset($state->assign_to_employee) || isset($state->assign_to_designation) || isset($state->assign_to_department)){
                if($state->assign_to_employee !== $user->id
                    && $state->assign_to_designation !== $employee->designation_id
                    && $state->assign_to_department !== $employee->department_id){
                        $originalEvent->setBlocked(true);
                        return;
                }

            }
        }



        $workflowClass = 'Modules\\Workflow\\Workflows\\'.Str::studly($workflow->requestType->type).'Workflow';

        if(class_exists($workflowClass)){
            $workflowObj = new $workflowClass();
            if($workflowObj->guard($originalEvent) == true){
                $originalEvent->setBlocked(false);
            }
            else{
                $originalEvent->setBlocked(true);
            }
        }
        else{
            $originalEvent->setBlocked(false);
        }
    }

    /**
     * Handle workflow leave event.
     */
    public function onLeave($event) {}

    /**
     * Handle workflow transition event.
     */
    public function onTransition($event) {
        /** Symfony\Component\Workflow\Event\GuardEvent */


        $originalEvent = $event->getOriginalEvent();

        $workflow = $originalEvent->getSubject();
        $transition = $originalEvent->getTransition();

        $workflowStatus = app(WorkflowStatusRepository::class)
            ->findByAttributes([
                'request_type_id' => $workflow->request_type_id,
                'worklow_place' => $transition->getTos()
            ]);

        $workflowClass = 'Modules\\Workflow\\Workflows\\'.Str::studly($workflow->requestType->type).'Workflow';

        if(class_exists($workflowClass)){
            $workflowObj = new $workflowClass();
            $workflowObj->applyTransition($originalEvent,$workflowStatus);
        }

        WorkflowService::applyTransition($workflow,$transition,$workflowStatus);
    }

    /**
     * Handle workflow enter event.
     */
    public function onEnter($event) {}

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Brexis\LaravelWorkflow\Events\GuardEvent',
            'Modules\Workflow\Events\Handlers\WorkflowSubscriber@onGuard'
        );

        $events->listen(
            'Brexis\LaravelWorkflow\Events\LeaveEvent',
            'Modules\Workflow\Events\Handlers\WorkflowSubscriber@onLeave'
        );

        $events->listen(
            'Brexis\LaravelWorkflow\Events\TransitionEvent',
            'Modules\Workflow\Events\Handlers\WorkflowSubscriber@onTransition'
        );

        $events->listen(
            'Brexis\LaravelWorkflow\Events\EnterEvent',
            'Modules\Workflow\Events\Handlers\WorkflowSubscriber@onEnter'
        );
    }

}