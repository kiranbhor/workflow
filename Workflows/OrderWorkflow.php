<?php


namespace Modules\Workflow\Workflows;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Accounting\Repositories\InvoiceRepository;
use Modules\Master\Repositories\EmployeeRepository;
use Modules\Sales\Repositories\OrderRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Workflow\Repositories\WorkflowRepository;
use Modules\Workflow\Repositories\WorkflowStatusRepository;
use Symfony\Component\Workflow\Event\GuardEvent;

class OrderWorkflow implements Workflow
{


    /**
     * @inheritDoc
     */
    public function approve($requestId, $workflow)
    {
        // TODO: Implement approve() method.
    }

    /**
     * @inheritDoc
     */
    public function reject($requestId, $workflow)
    {
        // TODO: Implement reject() method.
    }

    /**
     * @inheritDoc
     */
    public function cancel($requestId, $workflow)
    {
        // TODO: Implement cancel() method.
    }

    /**
     * @inheritDoc
     */
    public function forward($requestId, $workflow, $toUser, $fromUser = null)
    {
        // TODO: Implement forward() method.
    }


    /**
     * @inheritDoc
     */
    public function guard(GuardEvent $event)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function applyTransition($event,$workflowStatus)
    {
        $workflow = $event->getSubject();

        $orderRepo = app(OrderRepository::class);


        $order = $orderRepo->find($workflow->request_ref_id);
        $order->status_id = $workflowStatus->id;

        $transition = $event->getTransition()->getName();

        if($transition == ORDER_ACCEPTED_TRANSITION){
            $client = $order->client;
            $order->order_accepted = true;
            $client->available_limit = $client->available_limit - $order->total;

            //Set expiry date for DSC
            foreach ($order->orderproduct as $orderProduct){
                if($orderProduct->product->producttype_id == PRODUCTTYPE_DSC){
                    $orderProduct->expiry_date = Carbon::now()->addYears($orderProduct->product->validity);
                    $orderProduct->save();
                }
            }

            $order->client()->save($client);
        } elseif ($transition == ORDER_GENERATE_INVOICE_TRANSITION){

            if(session()->get('bulkTransitionInProgress') === true ){
                 if(session()->get('lastBulkTransition') === true) {

                     $orderIds = app(WorkflowRepository::class)->allWithBuilder()
                         ->whereIn('id', session()->get('buklWorkflowId'))
                         ->pluck('request_ref_id');

                     $orders = $orderRepo->allWithBuilder()->whereIn('id', $orderIds)->get();
                     app(InvoiceRepository::class)->generateOrderInvoice($orders);
                 }
            }
            else{
                app(InvoiceRepository::class)->generateOrderInvoice([$order]);
            }

        }

        $order->save();
    }


}