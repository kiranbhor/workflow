@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('workflow::requesttypes.title.edit requesttype') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.workflow.requesttype.index') }}">{{ trans('workflow::requesttypes.title.requesttypes') }}</a></li>
        <li class="active">{{ trans('workflow::requesttypes.title.edit requesttype') }}</li>
    </ol>
@stop

@section('styles')
    {!! Theme::script('js/vendor/ckeditor/ckeditor.js') !!}
@stop

@section('content')

    {!! Former::populate($requesttype) !!}

    {!!
        Former::horizontal_open()
            ->route('admin.workflow.requesttype.update',$requesttype->id)
            ->method('PUT')
    !!}

    {{   csrf_field() }}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">New Request</h3>
                </div>

                <div class="box-body">
                    @include('workflow::admin.requesttypes.partials.create-fields')
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>


            </div>
        </div>
    </div>
    {!!
       Former::close()
    !!}
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
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.workflow.requesttype.index') ?>" }
                ]
            });

            initializeUI();
        });
    </script>
    <script type="text/javascript">

        function initializeUI() {
            $('select').select2({
                allowClear: true,
                placeholder: $(this).data('placeholder')
            });
        }

    </script>
@stop
