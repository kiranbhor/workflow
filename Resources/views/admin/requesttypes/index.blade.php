@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('workflow::requesttypes.title.requesttypes') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('workflow::requesttypes.title.requesttypes') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.workflow.requesttype.create') }}" class="btn btn-primary btn-flat"
                       style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('workflow::requesttypes.button.create requesttype') }}
                    </a>
                </div>
            </div>
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
                                    <input name="chk_select_all" value="1" id="select-all" type="checkbox"/>
                                </th>
                                <th>type</th>
                                <th>description</th>
                                <th>created_by</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($requesttypes))
                                @foreach ($requesttypes as $requesttype)
                                    <tr>
                                        <td><input type="checkbox" class="bulk-action-chk"
                                                   data-id="{{$requesttype->id}}"></td>
                                        <td>{{ $requesttype->type }}</td>
                                        <td>{{ $requesttype->description }}</td>
                                        <td>{{ $requesttype->created_by }}</td>
                                        <td>
                                            <a href="{{ route('admin.workflow.requesttype.edit', [$requesttype->id]) }}">
                                                {{ $requesttype->created_at }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.workflow.requesttype.edit', [$requesttype->id]) }}"
                                                   class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-flat" data-toggle="modal"
                                                        data-target="#modal-delete-confirmation"
                                                        data-action-target="{{ route('admin.workflow.requesttype.destroy', [$requesttype->id]) }}">
                                                    <i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>type</th>
                                <th>description</th>
                                <th>created_by</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
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
        <dd>{{ trans('workflow::requesttypes.title.create requesttype') }}</dd>
    </dl>
@stop


@section('scripts')
    <script type="text/javascript">

        $("#default-designation-id").select2({
//            placeholder: 'Select an item',
            width: '100%',
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypressAction({
                actions: [
                    {key: 'c', route: "<?= route('admin.workflow.requesttype.create') ?>"}
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[0, "desc"]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
            $('#select-all').on('click', function () {
                var rows = categoryTable.rows({'search': 'applied'}).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            $('#filetypedategory-table tbody').on('change', 'input[type="checkbox"]', function () {
                // If checkbox is not checked
                if (!this.checked) {
                    var el = $('#select-all').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if (el && el.checked && ('indeterminate' in el)) {
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
                $("#type").val($(this).data("type"));
                $("#update-form").find('input[name="type"]').val($(this).data("type"));
                $("#update-form").find('input[name="parent_request_id"]').val($(this).data("parent_request_id"));
                $("#update-form").find('input[name="sequence_no"]').val($(this).data("sequence_no"));
                $("#update-form").find('input[name="description"]').val($(this).data("description"));
                $("#update-form").find('input[name="send_email_notification"]').val($(this).data("send_email_notification"));
                $("#update-form").find('input[name="notify_to_supervisor"]').val($(this).data("notify_to_supervisor"));
                $("#update-form").find('input[name="repository"]').val($(this).data("repository"));
                $("#update-form").find('input[name="validity_days"]').val($(this).data("validity_days"));
                $("#update-form").find('input[name="additional_emails_to_notify"]').val($(this).data("additional_emails_to_notify"));
                $("#update-form").find('input[name="initial_request_status_id"]').val($(this).data("initial_request_status_id"));
                $("#update-form").find('input[name="assign_to_supervisor"]').val($(this).data("assign_to_supervisor"));
                $("#update-form").find('input[name="update_request_route"]').val($(this).data("update_request_route"));
                $("#update-form").find('input[name="create_request_route"]').val($(this).data("create_request_route"));

                $("#update-div").show();
            });
            $("#btn-cancel-update").click(function (event) {
                event.preventDefault();
                $("#category-list").show();
                $("#update-div").hide();

            });
            $("#btn-update").click(function (event) {
                event.preventDefault();
                $("#category-list").show();
                $("#update-div").hide();

            });
        });
    </script>

@stop
