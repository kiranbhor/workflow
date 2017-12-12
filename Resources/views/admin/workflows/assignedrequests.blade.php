<?php use Carbon\Carbon;?>
@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('workflow::workflows.title.received requests') }}

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('workflow::workflows.title.received requests') }}</li>
    </ol>
@stop

@section('content')
    {!! Former::open(route('workflows.bulk'))
		->addClass('listForm') !!}

    {!! Former::hidden('action')->id('action') !!}
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">

                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <div>
                        <div class="pull-left" >
                            {!! DropdownButton::normal('Actions')
                                    ->withContents($bulkActions)
                                    ->withAttributes(['class'=>'action'])
                                    ->split() !!}
                        </div>
                        <div class="col-md-4">
                            {!! Former::multiselect('request_type_id')
                                    ->data_placeholder('Type')
                                    ->label('Request Type')
                                    ->fromQuery($requestTypes,'type','id')
                                    ->raw()
                            !!}
                        </div>
                        <div class="col-md-4">
                            {!! Former::multiselect('request_status_id')
                                  ->data_placeholder('Status')
                                  ->label('Request Type')
                                  ->fromQuery($requestTypes,'type','id')
                                  ->raw()
                          !!}
                        </div>
                        <div id="top_right_buttons" class="pull-right">

                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="selectAll" >
                                </th>
                                <th>Id</th>
                                <th>Date</th>
                                <th>Assigned By</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>User Note</th>
                                <th>Details</th>
                                <th>Assigned To</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    {!! Former::close() !!}


    <!-- Modal -->
    <div class="modal fade" id="commonModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Details of Request</h4>
                </div>
                <div class="modal-body">
                    <div class="te"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a type="button" href="" class="btn btn-primary"></a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!-- Transition Modal -->
    <div class="modal fade" id="apply-transition-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{'Approve Request'}}</h4>
                </div>
                <div class="modal-body">
                    <input type ="hidden" id="workflow_id" name = "workflow_id" value = "" >
                    <p>
                        Do you really want to <span id="type" value=""></span> from <span id="name" value=""></span>.
                    </p>
                    <P>
                    <div>
                        {!! Form::label('user_note', 'Please provide your comments') !!}
                        <textarea name="user_note" id="user_note" class="form-control" value="{{Input::old('user_note') }}" placeholder="Note">{{Input::old('user_note') }}</textarea>
                        {!! $errors->first('user_note', '<span class="help-block">:message</span>') !!}
                    </div>
                    </P>
                    <input type="hidden" id="transition">
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}
                    </button>

                    <a type="submit" id="transition-button" onClick="applyTransition()">
                    </a>

                </div>
            </div>
        </div>
    </div>

    <!-- ApproveModal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{'Approve Request'}}</h4>
                </div>
                <div class="modal-body">
                    <input type ="hidden" id="workflow_id" name = "workflow_id" value = "" >
                    <p>
                        Do you really want to approve <span id="type" value=""></span> from <span id="name" value=""></span>.
                    </p>
                    <P>
                    <div>
                        {!! Form::label('user_note', 'Please provide your comments') !!}
                        <textarea name="user_note" id="user_note" class="form-control" value="{{Input::old('user_note') }}" placeholder="Note">{{Input::old('user_note') }}</textarea>
                        {!! $errors->first('user_note', '<span class="help-block">:message</span>') !!}
                    </div>
                    </P>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}
                    </button>

                    <button type="submit" id="approveButton" class="btn btn-primary btn-flat" onClick="approveWorkflow()"><i class="glyphicon glyphicon-ok"></i> Approve
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- RejectModal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{'Reject Request'}}</h4>
                </div>
                <div class="modal-body">
                    <input type ="hidden" id="rworkflow_id" name = "workflow_id" value = "" >
                    <p>
                        Do you really want to reject <span id="rtype" value=""></span> from <span id="rname" value=""></span> to your manager.
                    </p>
                    <P>
                    <div>
                        {!! Form::label('user_note_r', 'Please provide your comments') !!}
                        <textarea name="user_note_r" id="user_note_r" class="form-control" value="{{Input::old('user_note_r') }}" placeholder="Note">{{Input::old('user_note_r') }}</textarea>
                        {!! $errors->first('user_note_r', '<span class="help-block">:message</span>') !!}
                    </div>
                    </P>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}
                    </button>

                    <button type="submit" id="rejectButton" class="btn btn-primary btn-flat" onClick="rejectWorkflow()"><i class="glyphicon glyphicon-trash"></i> Reject
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- ForwardModal -->
    <div class="modal fade" id="forwardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{'Forward Request'}}</h4>
                </div>
                <div class="modal-body">
                    <input type ="hidden" id="fworkflow_id" name = "workflow_id" value = "" >
                    <p>
                        Do you really want to forward <span id="ftype" value=""></span> from <span id="fname" value=""></span> to your manager.
                    </p>
                    <P>
                    <div>
                        {!! Form::label('user_note_f', 'Please provide your comments') !!}
                        <textarea name="user_note_f" id="user_note_f" class="form-control" value="{{Input::old('user_note_f') }}" placeholder="Note">{{Input::old('user_note_f') }}</textarea>
                        {!! $errors->first('user_note_f', '<span class="help-block">:message</span>') !!}
                    </div>
                    </P>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}
                    </button>

                    <button type="submit" id="forwardButton" class="btn btn-primary btn-flat" onClick="forwardWorkflow()"><i class="glyphicon glyphicon-forward"></i> Forward
                    </button>

                </div>
            </div>
        </div>
    </div>


@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('workflow::workflows.title.create workflow') }}</dd>
    </dl>
@stop

@section('scripts')

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?=route('admin.workflow.workflow.create')?>" }
                ]
            });
        });
    </script>

    <?php $locale = locale();?>
    <script type="text/javascript">
        var selectedWorkflows = [];
        var workflowTable;

        $( document ).ready(function() {

            $('.selectAll').click(function() {
                $(this).closest('table').find(':checkbox:not(:disabled)').prop('checked', this.checked);
            });

            setBulkActionsEnabled();
            initilizeUi();
        });

        /**
         * Decides whether to enable bulk action
         */
        function setBulkActionsEnabled() {
            var buttonLabel = "action";
            var count = $('.listForm tbody :checkbox:checked').length;
            $('.listForm button.action').prop('disabled', !count);
            if (count) {
                buttonLabel += ' (' + count + ')';
            }
            $('.button.action').not('.dropdown-toggle').text(buttonLabel);
        }

        /**
         * Decides whether to enable bulk action
         */
        function attachActionEvent(){

            selectedWorkflows = [];

            $('.data-table').on('click','.transition-button',function() {
                //check for multiple selection of users for approval
                if(selectedWorkflows.length >1) {
                    $('#name').text('all selected users');
                }
                else {
                    $('#name').text($(this).data('name'));
                }

                $('#workflow_id').val($(this).data('id'));
                $('#type').text($(this).data('text') + ' '+ $(this).data('requesttype'));
                $('#transition').val($(this).data('transition'));
                $('#transition-button').html($(this).data('html'));
                $('#user_note').text('');

            });
            $('.data-table').on('click','.approve-workflow',function() {
                //check for multiple selection of users for approval
                if(selectedWorkflows.length >1) {
                    $('#name').text('all selected users');
                }
                else {
                    $('#name').text($(this).data('name'));
                }

                $('#workflow_id').val($(this).data('id'));
                $('#type').text($(this).data('requesttype'));

            });
            $('.data-table').on('click','.reject-workflow',function() {

                //check for multiple selection of users for rejection
                if(selectedWorkflows.length >1) {
                    $('#rname').text('all selected users');
                }
                else {
                    $('#rname').text($(this).data('name'));
                }

                $('#rworkflow_id').val($(this).data('id'));
                $('#rtype').text($(this).data('requesttype'));

            });
            $('.data-table').on('click','.forward-workflow',function() {

                //check for multiple selection of users for forwarding
                if(selectedWorkflows.length >1) {
                    $('#fname').text('all selected users');
                }
                else {
                    $('#fname').text($(this).data('name'));
                }
                $('#fworkflow_id').val($(this).data('id'));
                $('#ftype').text($(this).data('requesttype'));

            });
            $('.data-table').on('change','.dynamic-check-box',function() {
                var workflowId =$(this).data('id');
                selectedWorkflows.push(workflowId);
            });

            $(':checkbox').click(function() {
                setBulkActionsEnabled();
            });

            $('.listForm tbody tr').unbind('click').click(function(event) {
                if (event.target.type !== 'checkbox' && event.target.type !== 'button' && event.target.tagName.toLowerCase() !== 'a') {
                    $checkbox = $(this).closest('tr').find(':checkbox:not(:disabled)');
                    var checked = $checkbox.prop('checked');
                    $checkbox.prop('checked', !checked);
                    setBulkActionsEnabled();
                }
            });

        }

        /**
         * Apply Transition
         */
        function applyTransition() {
            var workflowId = $('#workflow_id').val();
            var path = '{{ route('admin.workflow.workflow.applytransition',["id"]) }}';
            var repath = path.replace("id",workflowId);

            $('#approveButton').prop('disabled',false);

            $.ajax({
                type: 'POST',
                url: repath,
                data:{
                    'user_note' :$('#user_note').val(),
                    'transition' :$('#transition').val(),
                    '_token' :  $('meta[name="token"]').attr('value')
                },
                success: function(data) {
                    if(data.success == true) {
                        //swal("Approval", data.message,"success");
                        alert("Approved");

                    }
                    else{
                        //swal("Approval",data.message,"error");
                        alert("Error");
                    }
                    $('#apply-transition-modal').modal('hide');
                    workflowTable.fnDraw();
                }
            });

        }

        /**
         *  Approve workflow
         */
        function approveWorkflow() {
            var workflowId = $('#workflow_id').val();
            var path = '{{ route('api.workflow.workflows.postApproveRequest',["id"]) }}';
            var repath = path.replace("id",workflowId);

            selectedWorkflows.push(workflowId);

            console.log(selectedWorkflows);

            $('#approveButton').prop('disabled',false);
            $.ajax({
                type: 'POST',
                url: repath,
                data:{
                    'workflow_id_selected' :selectedWorkflows,
                    'user_note' :$('#user_note').val(),
                    '_token' :  $('meta[name="token"]').attr('value')
                },
                success: function(data) {
                    if(data.success == true) {
                        swal("Approval", data.message,"success");
                        fetchRequestedInfo();
                    }
                    else{
                        swal("Approval",data.message,"error");

                    }
                    $('#approveModal').modal('hide');
                }
            });

        }

        /**
         *
         * Reject Workflow
         */
        function rejectWorkflow() {

            var workflowId = $('#rworkflow_id').val();
            var path = '{{ route('api.workflow.workflows.postRejectRequest',["id"]) }}';
            var repath = path.replace("id",workflowId);
            selectedWorkflows.push(workflowId);



            $('#rejectButton').prop('disabled',false);
            $.ajax({
                type: 'POST',
                url: repath,
                data:{
                    workflow_id_selected :selectedWorkflows,
                    user_note :$('#user_note_r').val(),
                    '_token' :  $('meta[name="token"]').attr('value'),
                },
                success: function(data) {

                    if(data.success == true) {
                        swal("Reject", data.message);
                        fetchRequestedInfo();
                    }
                    else{
                        swal("Reject",data.message,"error");
                    }
                    $('#rejectModal').modal('hide');

                }
            });

        }

        /**
         * Forword Workflow
         */
        function forwardWorkflow() {

            var workflowId = $('#fworkflow_id').val();
            var path = '{{ route('api.workflow.workflows.postForwardRequest',["id"]) }}';
            var repath = path.replace("id",workflowId);
            selectedWorkflows.push(workflowId);

            $('#forwardButton').prop('disabled',false);
            $.ajax({
                type: 'POST',
                url: repath,
                data:{
                    workflow_id_selected :selectedWorkflows,
                    user_note :$('#user_note_f').val(),
                    '_token' :  $('meta[name="token"]').attr('value')
                },
                success: function(data) {

                    if(data.success == true) {
                        swal("Forwarded", data.message);
                        fetchRequestedInfo()
                    }
                    else{
                        swal("Forward",data.message);
                    }
                    $('#forwardModal').modal('hide');
                }
            });

        }


        /**
         * Generates link for transition
         * @param transition
         * @param workflow
         * @returns {string}
         */
        function getTransitionLink(transition,workflow){
            return '<a  class="transition-button"  data-html="'+ transition.html +'"  data-name="'+ workflow.assigned_by + '" data-requesttype="'+ workflow.request_type.type + '" data-toggle="modal" data-target="#apply-transition-modal" data-text = "' + transition.text +'" data-id = "'+workflow.id +'" data-transition="'+ transition.name +'">'+ htmlUnescape(transition.html) +'</a>';
        }

        /**
         * Escape HTML charactors
         * @param str
         */
        function htmlUnescape(str){
            return str
                .replace(/&quot;/g, '"')
                .replace(/&#39;/g, "'")
                .replace(/&lt;/g, '<')
                .replace(/&gt;/g, '>')
                .replace(/&amp;/g, '&');
        }

        /**
         * Initialize a UI
         */
        function initilizeUi(){

            workflowTable = $('.data-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": '{{ route("admin.workflow.workflow.getAssignedRequests") }}',
                    "type":"get",
                    "data": function(d) {
                        d.typeVal = JSON.stringify($("#request_type_id").val());
                        d._token =  '{{ csrf_token() }}';
                    },
                },
                "drawCallback": function(settings, json) {
                    attachActionEvent();
                },
                columns: [
                    { data: 'chkbox',orderable: false},
                    { data: 'id'},
                    { data: 'date'},
                    { data: 'assigned_by'},
                    { data: 'type'},
                    { data: 'status' },
                    { data: 'user_note',orderable: false,  },
                    { data: 'request_text',orderable: false, },
                    { data: 'assigned_to'},
                    { data: 'actions',orderable: false,
                        render: function ( data, type, full, meta ){
                            var html = '<div class="btn-group">';
                            $.each(full.actions,function(index,action){
                                html += getTransitionLink(action,full);
                            });
                            html += '</div>';

                            return html;
                        }
                    }
                ],

            });


            $("#request_type_id , #request_status_id").select2({
                allowClear: true,
                placeholder: $(this).data('placeholder')
            }).on('change',function() {
                workflowTable.fnDraw();
            });
        }



        function submitForm(action, id) {
            $('#action').val(action);

            if (id) {
                $('#public_id').val(id);
            }

            $('form.listForm').submit();
        }

    </script>




@stop
