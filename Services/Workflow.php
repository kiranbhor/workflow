<?php
/**
 * Created by PhpStorm.
 * User: kiran
 * Date: 7/8/17
 * Time: 12:18 PM
 */

namespace Modules\Workflow\Services;


interface Workflow
{
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