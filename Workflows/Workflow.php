<?php
/**
 * Created by PhpStorm.
 * User: kiran
 * Date: 7/8/17
 * Time: 12:18 PM
 */

namespace Modules\Workflow\Workflows;


use Symfony\Component\Workflow\Event\GuardEvent;

interface Workflow
{

    /**
     * Guard the workflow action
     * @param GuardEvent $event
     * @return mixed
     */
    public function guard(GuardEvent $event);

    /**
     * Apply Given transition to workflow
     * @param $workflow
     * @param $transition
     * @return mixed
     */
    public function applyTransition($event,$workflowStatus);

    /**
     * Approves the given request
     * @param $requestId
     * @param $workflow
     * @return mixed
     */
    public function approve($requestId,$workflow);


    /**
     * Rejects the given request
     * @param $requestId
     * @param $workflow
     * @return mixed
     */
    public function reject($requestId,$workflow);

    /**
     * Cancels the given request
     * @param $requestId
     * @param $workflow
     * @return mixed
     */
    public function cancel($requestId,$workflow);

    /**
     * @param $requestId
     * @param $workflow
     * @param $toUser
     * @param null $fromUser
     * @return mixed
     */
    public function forward($requestId,$workflow,$toUser,$fromUser = null);
}