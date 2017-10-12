@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('workflow::workflowpriorities.title.workflowpriorities') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('workflow::workflowpriorities.title.workflowpriorities') }}</li>
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
                                <th>Priority</th>
                                <th>Sequence</th>
                                <th>CSS_class</th>
                                <th>task_default</th>
                                <th>{{ trans('type') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($workflowpriorities))
                            @foreach ($workflowpriorities as $workflowpriority)
                            <tr>
                                <td><input type="checkbox" class="bulk-action-chk" data-id="{{$workflowpriority->id}}"></td>
                                <td>{{ $workflowpriority->priority }}</td>
                                <td>{{ $workflowpriority->sequence_no }}</td>
                                <td>{{ $workflowpriority->css_class }}</td>
                                <td>{{ $workflowpriority->task_default }}</td>
                                <td>
                                    <a href="{{ route('admin.workflow.workflowpriority.edit', [$workflowpriority->id]) }}">
                                        {{ $workflowpriority->request_type_id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.workflow.workflowpriority.edit', [$workflowpriority->id]) }}">
                                        {{ $workflowpriority->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a  class="btn btn-default btn-flat category-edit-button" data-priority="{{ $workflowpriority->priority }}" data-sequence_no="{{$workflowpriority->sequence_no}}" data-css_class="{{$workflowpriority->css_class}}" data-task_default="{{$workflowpriority->task_default}}" data-id="{{$workflowpriority->id}}"><i class="fa fa-pencil"></i></a>
                                        {{--<a href="{{ route('admin.workflow.workflowpriority.edit', [$workflowpriority->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>--}}
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.workflow.workflowpriority.destroy', [$workflowpriority->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>Priority</th>
                                <th>Sequence</th>
                                <th>CSS_class</th>
                                <th>task_default</th>
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
                    <h3 class="box-title">Change Workflow Priority</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => ['admin.workflow.workflowpriority.update'], 'method' => 'post','id'=>'update-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('priority') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Priority</label>
                        <input type="text" class="form-control" id="priority"  name = "priority" autofocus placeholder="Enter Priority" value="{{ old('priority') }}">
                        {!! $errors->first('priority', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('sequence_no') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleSeqNumber">Enter Sequence Nuumber</label>
                        <input type="text" class="form-control" name="sequence_no" id="sequence-no" placeholder="Enter Sequence Number" value="{{ old('sequence_no') }}">
                        {!! $errors->first('sequence_no', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('css_class') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleCssclass">Enter CSS Class</label>
                        <input type="text" class="form-control" name="css_class" id="css-class" placeholder="Enter CSS Class" value="{{ old('css_class') }}">
                        {!! $errors->first('css_class', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('task_default') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleTask">Enter Task</label>
                        <input type="text" class="form-control" name="task_default" id="task-default" placeholder="Enter Task" value="{{ old('task_default') }}">
                        {!! $errors->first('task_default', '<span class="help-block">:message</span>') !!}
                    </div>
                    <input type="hidden" id="category-id" name="category_id">
                    <input type="hidden" id="old-priority" name="old_priority">


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


                {!! Form::open(['route' => ['admin.workflow.workflowpriority.store'], 'method' => 'post','id'=>'create-form']) !!}
                <div class="box-body">
                    <div class="form-group has-feedback {{ $errors->has('priority') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Priority</label>
                        <input type="text" class="form-control" id="priority"  name = "priority" autofocus placeholder="Enter Priority" value="{{ old('name') }}">
                        {!! $errors->first('priority', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('sequence_no') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleSeqNumber">Enter Sequence Nuumber</label>
                        <input type="text" class="form-control" name="sequence_no" id="sequence_no" placeholder="Enter Sequence Number">
                        {!! $errors->first('sequence_no', '<span class="help-block">:message</span>') !!}
                    </div>
                <div class="form-group" class="form-group has-feedback {{ $errors->has('css_class') ? ' has-error has-feedback' : '' }}">
                    <label for="exampleCssclass">Enter CSS Class</label>
                    <input type="text" class="form-control" name="css_class" id="css_class" placeholder="Enter CSS Class">
                    {!! $errors->first('css_class', '<span class="help-block">:message</span>') !!}
                </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('task_default') ? ' has-error has-feedback' : '' }}">
                        <label for="exampleTask">Enter Task</label>
                        <input type="text" class="form-control" name="task_default" id="task_default" placeholder="Enter Task">
                        {!! $errors->first('task_default', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('request_type_id') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Type</label>
                        {!! $errors->first('request_type_id', '<span class="help-block">:message</span>') !!}
                        <select class="itemName dropdown" id="itemName" name="request_type_id">
                            <option></option>
                            @foreach($requesttypeflow as $requesttype)
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
            <!-- /.box -->
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
        <dd>{{ trans('workflow::workflowpriorities.title.create workflowpriority') }}</dd>
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
                    { key: 'c', route: "<?= route('admin.workflow.workflowpriority.create') ?>" }
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
                $("#old-priority").val($(this).data("priority"));
                $("#update-form").find('input[name="priority"]').val($(this).data("priority"));
                $("#update-form").find('input[name="sequence_no"]').val($(this).data("sequence_no"));
                $("#update-form").find('input[name="css_class"]').val($(this).data("css_class"));
                $("#update-form").find('input[name="task_default"]').val($(this).data("task_default"));
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
    {!!  JsValidator::formRequest('Modules\Workflow\Http\Requests\Updateworkflowpriority','#update-form')->render() !!}
    {!!  JsValidator::formRequest('Modules\Workflow\Http\Requests\PriorityRequest','#create-form')->render() !!}

@stop
