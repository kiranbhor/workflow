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

@section('styles')

    {!! Theme::style('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') !!}
    {!! Theme::style('vendor/admin-lte/plugins/select2/select2.min.css') !!}

@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">

                </div>
            </div>


            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('request_type_id', 'Request Type') !!}
                                <select  class="form-control" name="request_type_id" id="request_type_id" placeholder="Select Request" multiple>
                                    <?php foreach ($requestTypes as $requestType): ?>
                                    <option value="{{ $requestType->id }}">{{ $requestType->type }}</option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th id="select">Select</th>
                            <th>Id</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>User Note</th>
                            <th>Details</th>
                            <th>Assigned To</th>
                            <th>Date</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th id="select">Select</th>
                            <th>Id</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>User Note</th>
                            <th>Details</th>
                            <th>Assigned To</th>
                            <th>Date</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>


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
    {!! Theme::script('vendor/admin-lte/plugins/select2/select2.min.js') !!}

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
        var tabl;
        var userId = "{{$currentUser->id}}";

        var pendingStatus = "{{STATUS_PENDING}}"
        var approvedStatus = "{{STATUS_APPROVED}}";
        var rejectedStatus = "{{STATUS_REJECTED}}";
        var forwardedStatus = "{{STATUS_FORWARDED}}";



        function attachSelectedWorkflows(){
            $('.data-table').on('change','.dynamic-check-box',function() {
                var workflowId =$(this).data('id');
                selectedWorkflows.push(workflowId);
            });
        }

        function attachActionEvent(){
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
        }

        function fetchRequestedInfo() {
            $(function () {
                tabl = $('.data-table').dataTable({
                    destroy:true,
                    paginate: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": '{{ route("api.workflow.workflows.getReceivedRequest") }}',
                        "data": function(d) {
                            var typeValue  = [];
                            if($("#request_type_id option:selected").attr('value') != -1) {
                                $("#request_type_id option:selected").each(function () {
                                    typeValue.push(this.value);
                                });
                            }
                            d.typeVal = JSON.stringify(typeValue);
                            d._token =  $('meta[name="token"]').attr('value')
                        }

                    },
                    "lengthChange": true,
                    "filter": true,
                    "sort": true,
                    "info": true,
                    "autoWidth": true,
                    "order": [[ 1, "desc" ]],
                    "language": {
                        "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                    },
                    "search": {
                        "caseInsensitive": false
                    },
                    "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                        nRow.setAttribute('id',('workflow-row-'+aData['id']));
                    },
                    columns: [
                        { data: 'select',
                            "render": function ( data, type, full, meta ) {
                                return '<input class="dynamic-check-box" name="check" type="checkbox" id="workflow_id_selected" data-id="'+full.id+'" class="flat-blue" />';
                            },
                        },
                        { data: 'id'},
                        { data:'assigned_by.first_name'},
                        { data: 'request_type.type',

                            "render": function ( data, type, full, meta ) {
                                var path = "{{ route('admin.workflow.workflows.getRequestDetails',["id"]) }}";
                                var repath = path.replace("id",full.id);

                                return '<a href="'+repath+'" class="" data-toggle="modal" data-target="#commonModal2">'+data+'</a>';
                            }

                        },
                        { data: 'request_status.status' ,
                            "render": function ( data, type, full, meta ) {
                                if(data != null) {
                                    return  '<span class="status-span label ' + full.request_status.label_class+'" title="'+data+'">'+data+ '</span>';
                                }
                                else {
                                    return 'NA';
                                }
                            },

                        },
                        { data: 'user_note' },
                        { data: 'request_text' },
                        { data: 'assigned_to.first_name'},
                        { data: 'datetime_added' ,
                            "render": function ( data, type, full, meta ) {
                                return  '<span class="label label-primary" title = "'+moment(data).format('DD MMM YY HH:mm')+'">'+moment(data).format('DD MMM YY HH:mm')+'</span>';
                            }
                        },
                        { data: 'id',
                            "render": function ( data, type, full, meta ) {

                                if(full.request_status_id != null) {
                                    if(full.is_open == true ) {
                                        if(full.assigned_to_user_id != userId) {

                                            if(full.request_status_id==forwardedStatus) {
                                                return '<span class="label label-default">Forwarded</span>';
                                            }
                                        }
                                        else {

                                            var responseHTML = '<div class="btn-group">';

                                            if(full.request_status_id != approvedStatus && full.request_type.show_approve_btn == true){
                                                responseHTML = responseHTML + '<a class="btn btn-default btn-flat approve-workflow" data-name="'+full.assigned_by.first_name+''+full.assigned_by.last_name+'" data-id="'+full.id+'" data-requesttype="'+full.request_type.type+'" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#approveModal"><i class="glyphicon glyphicon-ok" ></i></a>';
                                            }

                                            if(full.request_status_id != rejectedStatus && full.request_type.show_reject_btn	== true){
                                                responseHTML = responseHTML + '<a class="btn btn-danger btn-flat reject-workflow" data-name="'+full.assigned_by.first_name+''+full.assigned_by.last_name+'" data-id="'+full.id+'" data-requesttype="'+full.request_type.type+'" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#rejectModal"><i class="glyphicon glyphicon-remove"></i></a>';
                                            }

                                            if(full.request_status_id != forwardedStatus && full.request_type.show_forward_btn	== true){
                                                responseHTML = responseHTML + '<a class="btn btn-default btn-flat forward-workflow" data-name="'+full.assigned_by.first_name+''+full.assigned_by.last_name+'" data-id="'+full.id+'" data-requesttype="'+full.request_type.type+'" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#forwardModal"><i class="glyphicon glyphicon-forward"></i></a>';
                                            }

                                            return responseHTML + '</div>';
                                        }
                                    }
                                    else {

                                        return '<span class="label label-default">Closed</span>';
                                    }
                                }
                                else {
                                    return '<span class="label label-default">NA</span>';
                                }

                            }
                        }
                    ],

                });
                attachActionEvent();
                attachSelectedWorkflows();

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


        $( document ).ready(function() {
            $("#request_type_id").select2({
                placeholder: "Select Request"
            }).on('change',function() {
                fetchRequestedInfo();
            });

            fetchRequestedInfo();

        });

    </script>
@stop
