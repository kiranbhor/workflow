@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('workflow::requesttypes.title.create requesttype') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.workflow.requesttype.index') }}">{{ trans('workflow::requesttypes.title.requesttypes') }}</a></li>
        <li class="active">{{ trans('workflow::requesttypes.title.create requesttype') }}</li>
    </ol>
@stop


@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">New Request</h3>
                <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                    <span class="label label-primary">Label</span>
                </div>
                <!-- /.box-tools -->
            </div>
            {!!
                Former::horizontal_open()
                    ->route('admin.workflow.requesttype.store')
                    ->method('post')
            !!}
            <div class="box-body">

                {{   csrf_field() }}
                @include('workflow::admin.requesttypes.partials.create-fields')

            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Save</button>
            </div>
            {!!
               Former::close()
            !!}

        </div>
        </div>
    </div>
@stop



@section('scripts')

    <script type="text/javascript">

        function initializeUI() {
            $('select').select2({
                allowClear: true,
                placeholder: $(this).data('placeholder')
            });
        }

    </script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.workflow.requesttype.index') ?>" }
                ]
            });
        });

        initializeUI();

    </script>
@stop
