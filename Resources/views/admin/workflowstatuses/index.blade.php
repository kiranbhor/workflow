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
@section('styles')
    {!! Theme::script('vendor/admin-lte/plugins/select2/select2.min.js') !!}
    {!! Theme::style('vendor/admin-lte/plugins/select2/select2.min.css') !!}
@stop


@section('content')
    <div class="row">
        <div class="col-xs-8">
            <div class="box box-primary" id="category-list">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
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
                                <td>
                                    <a href="{{ route('admin.workflow.workflowpriority.edit', [$workflowstatus->id]) }}">
                                        {{ $workflowstatus->request_type_id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.workflow.workflowstatus.edit', [$workflowstatus->id]) }}">
                                        {{ $workflowstatus->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a  class="btn btn-default btn-flat category-edit-button" data-status="{{ $workflowstatus->status }}" data-sequence_no="{{$workflowstatus->sequence_no}}" data-label_class="{{$workflowstatus->label_class}}" data-is_closing_status="{{$workflowstatus->is_closing_status}}" data-id="{{$workflowstatus->id}}"><i class="fa fa-pencil"></i></a>
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
                <!-- /.box -->
            </div>
            <div id ="update-div" class="box box-primary" hidden>
                <div class="box-header with-border">
                    <h3 class="box-title">Change Workflow Status</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => ['admin.workflow.workflowstatus.update'], 'method' => 'post','id'=>'update-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('status') ? ' has-error has-feedback' : '' }}">
                        <label for="type-status">Enter Status</label>
                        <input type="text" class="form-control" id="status"  name = "status" autofocus placeholder="Enter Status" value="{{ old('status') }}">
                        {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('sequence_no') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleSeqNumber">Enter Sequence Nuumber</label>
                        <input type="text" class="form-control" name="sequence_no" id="sequence-no" placeholder="Enter Sequence Number" value="{{ old('sequence_no') }}">
                        {!! $errors->first('sequence_no', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('label_class') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleLabelclass">Enter Label Class</label>
                        <input type="text" class="form-control" name="label_class" id="label-class" placeholder="Enter Label Class" value="{{ old('label_class') }}">
                        {!! $errors->first('label_class', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('is_closing_status') ? ' has-error has-feedback' : '' }}">
                        <label for="closingStatus">Enter Closing Status</label>
                        <input type="text" class="form-control" name="is_closing_status" id="is-closing-status" placeholder="Enter Closing Status" value="{{ old('is_closing_status') }}">
                        {!! $errors->first('is_closing_status', '<span class="help-block">:message</span>') !!}
                    </div>
                    <input type="hidden" id="category-id" name="category_id">
                    <input type="hidden" id="old-status" name="old_status">


                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button class="btn btn-primary pull-left" id="btn-cancel-update">Cancel</button>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-xs-4">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">New Workflow Priority</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->


                {!! Form::open(['route' => ['admin.workflow.workflowstatus.store'], 'method' => 'post','id'=>'create-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('status') ? ' has-error has-feedback' : '' }}">
                        <label for="type-status">Enter Status</label>
                        <input type="text" class="form-control" id="status"  name = "status" autofocus placeholder="Enter Status">
                        {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('sequence_no') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleSeqNumber">Enter Sequence Nuumber</label>
                        <input type="text" class="form-control" name="sequence_no" id="sequence_no" placeholder="Enter Sequence Number">
                        {!! $errors->first('sequence_no', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('label_class') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleLabelclass">Enter Label Class</label>
                        <input type="text" class="form-control" name="label_class" id="label_class" placeholder="Enter Label Class">
                        {!! $errors->first('label_class', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('is_closing_status') ? ' has-error has-feedback' : '' }}">
                        <label for="closingStatus">Enter Closing Status</label>
                        <input type="text" class="form-control" name="is_closing_status" id="is_closing_status" placeholder="Enter Closing Status">
                        {!! $errors->first('is_closing_status', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('request_type_id') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Type</label>
                        {!! $errors->first('request_type_id', '<span class="help-block">:message</span>') !!}
                        <select class="itemName dropdown" id="itemName" name="request_type_id">
                            <option></option>
                            @foreach($requeststatusflow as $requesttype)
                                <option value="{{$requesttype->id}}">
                                    {{$requesttype->type}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Create</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
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
    {!!  JsValidator::formRequest('Modules\Workflow\Http\Requests\UpdatestatusRequest','#update-form')->render() !!}
    {!!  JsValidator::formRequest('Modules\Workflow\Http\Requests\Statusrequest','#create-form')->render() !!}

@stop
