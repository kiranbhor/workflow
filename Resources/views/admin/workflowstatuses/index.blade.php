@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('workflow::workflowstatuses.title.workflowstatuses') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('workflow::workflowstatuses.title.workflowstatuses') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.workflow.workflowstatus.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('workflow::workflowstatuses.button.create workflowstatus') }}
                    </a>
                </div>
            </div>

            <div class="box box-primary" id="category-list">
                <div class="box-header">
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table id="filetypedategory-table" class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <input name="chk_select_all" value="1" id="select-all" type="checkbox" />
                                </th>
                                <th>Status</th>
                                <th>Sequence</th>
                                <th>Label_class</th>
                                <th>Closing Status</th>
                                <th>{{ trans('type') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($workflowstatuses))
                            @foreach($workflowstatuses as $workflowstatus)
                            <tr>
                                <td><input type="checkbox" class="bulk-action-chk" data-id="{{$workflowstatus->id}}"></td>
                                <td>{{ $workflowstatus->status }}</td>
                                <td>{{ $workflowstatus->sequence_no }}</td>
                                <td>{{ $workflowstatus->label_class }}</td>
                                <td>{{ $workflowstatus->is_closing_status }}</td>
                                <td>{{ (isset($workflowstatus->requestType)?$workflowstatus->requestType->type:'NA')}}</td>
                                <td>
                                    <a href="{{ route('admin.workflow.workflowstatus.edit', [$workflowstatus->id]) }}">
                                        {{ $workflowstatus->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a  class="btn btn-default btn-flat category-edit-button" href="{{route('admin.workflow.workflowstatus.edit',$workflowstatus->id)}}"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.workflow.workflowstatus.destroy', [$workflowstatus->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>Status</th>
                                <th>Sequence</th>
                                <th>Label_class</th>
                                <th>Closing Status</th>
                                <th>{{ trans('type') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
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
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('workflow::workflowstatuses.title.create workflowstatus') }}</dd>
    </dl>
@stop

@section('scripts')
    <script type="text/javascript">

        $("#itemName").select2({
            placeholder: 'Select an item',
            width:'100%',
        });
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.workflow.workflowstatus.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            var categoryTable =  $('#filetypedategory-table').DataTable({
//            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
            $('#select-all').on('click', function(){
// Check/uncheck all checkboxes in the table
                var rows = categoryTable.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            $('#filetypedategory-table tbody').on('change', 'input[type="checkbox"]', function(){
                // If checkbox is not checked
                if(!this.checked){
                    var el = $('#select-all').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if(el && el.checked && ('indeterminate' in el)){
                        // Set visual state of "Select all" control
                        // as 'indeterminate'
                        el.indeterminate = true;
                    }
                }
            });
            $(".category-edit-button").click(function () {
//                var action =  $('#update-form').attr('action').replace(":id",$(this).data("id"))
                $("#category-list").hide();
                $("#category-id").val($(this).data("id"));
                $("#old-status").val($(this).data("status"));
                $("#update-form").find('input[name="status"]').val($(this).data("priority"));
                $("#update-form").find('input[name="sequence_no"]').val($(this).data("sequence_no"));
                $("#update-form").find('input[name="label_class"]').val($(this).data("label_class"));
                $("#update-form").find('input[name="is_closing_status"]').val($(this).data("is_closing_status"));
//                $("#update-form").attr('action',action);
//                $("#update-form").find('input[name="type"]').val($(this).data("type"))
                $("#update-div").show();
            });
            $("#btn-cancel-update").click(function(event){
                event.preventDefault();
                $("#category-list").show();
                $("#update-div").hide();

            });
            $("#btn-update").click(function(event){
                event.preventDefault();
                $("#category-list").show();
                $("#update-div").hide();

            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!!  JsValidator::formRequest('Modules\Workflow\Http\Requests\UpdateWorkflowStatusRequest','#update-form')->render() !!}
    {!!  JsValidator::formRequest('Modules\Workflow\Http\Requests\CreateWorkflowStatusRequest','#create-form')->render() !!}

@stop
