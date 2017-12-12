<?php use Carbon\Carbon;?>
@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('workflow::workflows.title.workflows') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('workflow::workflows.title.workflows') }}</li>
    </ol>
@stop

@section('styles')
@stop


@section('content')



    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="#" class="btn btn-danger"  data-toggle="modal" data-target="#confirmation-delete-selected" style="padding: 4px 10px;">{{ trans('workflow::workflows.messages.delete') }}</a>

                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="workflow-data-table" class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th id="select">Select</th>
                                <th id ="id">Request Id</th>
                                <th id ="type">Request type</th>
                                <th id ="status">Request status</th>
                                <th id ="usercomment">User Comment</th>
                                <th id ="manager">Manager</th>
                                <th id ="comment">Manager Comment</th>
                                <th id ="requestdata">Request Date</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr><th>Select</th>
                                <th>Request Id</th>
                                <th>Request type</th>
                                <th>Request status</th>
                                <th>User Comment</th>
                                <th>Manager</th>
                                <th>Comment From Manager</th>
                                <th>Request Date</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="commonModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
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

    <div class="modal fade modal-danger" id="confirmation-delete-selected" tabindex="-1" role="dialog" aria-labelledby="deleteSelectedNotification" aria-hid  den="true">
            <div class="modal-dialog modal-danger">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ trans('core::core.modal.title') }}</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete the selected workflows??
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}</button>

                        <button type="submit" class="btn btn-outline btn-flat " id="deleteSelectedButton" onClick="bindDeleteSelectedEvent()"><i class="glyphicon glyphicon-trash"></i> {{ trans('core::core.button.delete') }}</button>

                    </div>
                </div>
            </div>
        </div>

    @include('core::partials.delete-modal')

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-danger">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('core::core.modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="workflow_id" value="" name="workflow_id" >
                    {{ trans('core::core.modal.confirmation-message') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline btn-flat" data-dismiss="modal">{{ trans('core::core.button.cancel') }}</button>
                    <button type="submit" class="btn btn-outline btn-flat modal-delete-workflow" onClick="bindDeleteEvent()"><i class="glyphicon glyphicon-trash"></i> {{ trans('core::core.button.delete') }}</button>

                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop

@section('scripts')
    <?php $locale = locale(); ?>
    <script type="text/javascript">

        function attachDeleteEvent(){
            $('#workflow-data-table').on('click','.delete-workflow',function() {
                $('#workflow_id').val($(this).data('id'));
            });
        }

        var selectedWorkflows = [];

        function attachSelectedDeleteEvent(){
            $('#workflow-data-table').on('change','.dynamic-check-box',function() {
                var workflowId =$(this).data('id');
                selectedWorkflows.push(workflowId);
            });
        }

        var table;

        $(function () {
            table = $('#workflow-data-table').DataTable({
                "paginate": true,
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": '{{ route("api.workflow.workflows.get") }}',
                },
                "deferRender": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
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
                    { data: 'request_type.type'},
                    { data: 'status.status' ,
                        "render": function ( data, type, full, meta ) {
                            if(data != null) {
                                return  '<span class="status-span label ' + full.status.label_class+'" title="'+data+'">'+data+ '</span>';
                            }
                            else {
                                return 'NA';
                            }
                        },

                    },
                    { data: 'request_text' },
                    { data: 'assigned_user.first_name' ,
                        "render": function ( data, type, full, meta ) {
                            return  '<span title = "'+full.assigned_user.first_name+'">'+data+' '+full.assigned_user.last_name+'</span>';
                        }

                    },
                    { data: 'supervisor_note' },
                    { data: 'datetime_added' ,

                        "render": function ( data, type, full, meta ) {
                            return  '<span class="label label-primary" title = "'+moment(data).format('DD MMM YY HH:mm')+'">'+moment(data).format('DD MMM YY HH:mm')+'</span>';
                        }
                    },
                    { data: 'id',
                        "render": function ( data, type, full, meta ) {

                            if(full.is_open == true) {
                                var deletePath = "{{ route('api.workflow.workflow.destroy', ["id"]) }}";
                                var deleteRepath = deletePath.replace("id",full.id);
                                return '<a class="btn btn-danger btn-flat delete-workflow" data-id="'+full.id+'" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#deleteModal" ><i class="glyphicon glyphicon-trash" ></i></a>';
                            }
                            else {
                                return '<span class="label label-default">Closed</span>';
                            }

                        }
                    }
                ],
            });
            attachDeleteEvent();
            attachSelectedDeleteEvent();
        });

        function bindDeleteSelectedEvent() {

            var path = '{{ route('api.workflow.workflows.destroySelected')}}';

            $.ajax({
                type: 'POST',
                url: path,
                data:{
                    workflow_id_selected :selectedWorkflows,
                    _token:$('meta[name="token"]').attr('value'),
                },
                success: function(data) {
                    swal(""," Selected Workflows are deleted successfully");

                    $('#confirmation-delete-selected').modal('hide');
                    $.each(selectedWorkflows,function(id,obj) {
                        $('table').find("#workflow-row-"+ obj).remove();
                    });
                }
            });
        }


        function bindDeleteEvent() {

            var row_no=$(table).closest("tr").attr("id");
            var workflowId = $('#workflow_id').val();
            var path = '{{ route('api.workflow.workflow.destroy',["id"]) }}';
            path = path.replace("id",workflowId);

            $.ajax({
                type: 'DELETE',
                url: path,
                data:{
                    workflow_id :workflowId,
                    _token:$('meta[name="token"]').attr('value'),
                },
                success: function(data) {
                    swal("","Request is deleted successfully");
                    $('#deleteModal').modal('hide');
                    $('table').find("#workflow-row-"+ workflowId).remove();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal("Oops","Something went wrong, Please contact support","Error");
                }
            });
        }


    </script>
@stop
