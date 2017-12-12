@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('workflow::workflowstatuses.title.edit workflowstatus') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.workflow.workflowstatus.index') }}">{{ trans('workflow::workflowstatuses.title.workflowstatuses') }}</a></li>
        <li class="active">{{ trans('workflow::workflowstatuses.title.edit workflowstatus') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')

    {{Former::populate($workflowstatus)}}

    {!! Former::open_horizontal('create-status')
        ->route('admin.workflow.workflowstatus.update',$workflowstatus->id)
        ->method('put')
    !!}

    {!! csrf_field() !!}

    <div class="row">
        <div class="col-md-8">
            <div class="box">
                @include('workflow::admin.workflowstatuses.partials.create-fields')
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.workflow.workflowstatus.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
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

@section('scripts')
    <script type="text/javascript">

        $( document ).ready(function() {
            initializeUI()
        });

        function initializeUI() {

            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            $('select').select2({
                allowClear: true,
                placeholder: $(this).data('placeholder')
            });

            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.workflow.workflowstatus.index') ?>" }
                ]
            });
        }

    </script>
@stop
