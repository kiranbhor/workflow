<?php use Carbon\Carbon;?>


<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Details of Leave Request</h4>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt>Reason for leave : </dt>
                        <dd>{{$data->details}}</dd>
                        <dt>Leave Type : </dt>
                        <dd>{{$data->leaveType->leave_type_name}}</dd>
                        <dt>Applied for : </dt>
                        <dd>{{$data->no_of_days}} days</dd>
                        <dt>Start Date : </dt>
                        <dd>{{Carbon::parse($data->start_date)->format($dateFormat)}}</dd>
                        <dt>Start Session : </dt>
                        <dd>{{getLeaveSessionName($data->end_session)}}</dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt>End Date : </dt>

                        <dd>{{Carbon::parse($data->end_date)->format($dateFormat)}}</dd>
                        <dt>End Session : </dt>
                        <dd>{{getLeaveSessionName($data->end_session)}}</dd>
                        <dt>Address On Leave : </dt>
                        <dd>{{$data->address_on_leave}}</dd>
                        <dt>Contact No : </dt>
                        <dd>{{$data->contact_no_on_leave}}</dd>

                    </dl>
                </div>
            </div>
            <div class="row"></div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 "></div>
                <div class="col-md-4 pull-left">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <div class="btn-group pull-right">

                @if($objWorkflow->is_open == true && $objWorkflow->requester_id != $currentUser->id && $objWorkflow->assigned_to_user_id == $currentUser->id)


                        @if($objWorkflow->request_status_id != STATUS_APPROVED && $objWorkflow->requestType->show_approve_btn == true)
                            <a class="btn btn-default btn-flat approve-workflow" data-name='{{$objWorkflow->assignedBy->first_name.' '.$objWorkflow->assignedBy->last_name}}' data-id="{{$objWorkflow->id}}'" data-requesttype="{{$objWorkflow->requestType->type}}" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#approveModal"><i class="glyphicon glyphicon-ok" ></i></a>
                        @endif

                        @if($objWorkflow->request_status_id != STATUS_REJECTED && $objWorkflow->requestType->show_reject_btn	== true)
                            <a class="btn btn-danger btn-flat reject-workflow"  data-name='{{$objWorkflow->assignedBy->first_name.' '.$objWorkflow->assignedBy->last_name}}' data-id="{{$objWorkflow->id}}'" data-requesttype="{{$objWorkflow->requestType->type}}" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#rejectModal"><i class="glyphicon glyphicon-remove"></i></a>
                        @endif

                        @if($objWorkflow->request_status_id != STATUS_FORWARDED && $objWorkflow->requestType->show_forward_btn	== true)
                            <a class="btn btn-default btn-flat forward-workflow" data-name='{{$objWorkflow->assignedBy->first_name.' '.$objWorkflow->assignedBy->last_name}}' data-id="{{$objWorkflow->id}}'" data-requesttype="{{$objWorkflow->requestType->type}}" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#forwardModal"><i class="glyphicon glyphicon-forward"></i></a>
                        @endif

                @endif
            </div>
        </div>
    </div>
</div>