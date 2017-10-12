
<div class="box-body">
    <div class="rows">
        {{--<div class="col-xs-12">--}}
        <div id="update-div" class="box box-default collapsed-box" hidden>
            <div  class="box-header with-border">
                <h3 class="box-title">Required Fields</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

            {!! Form::open(['route' => ['admin.workflow.requesttype.update'], 'method' => 'post','id'=>'update-form']) !!}
            <div class="box-body">
                <div class="col-xs-4">
                    <div class="form-group has-feedback {{ $errors->has('type') ? ' has-error has-feedback' : '' }}">
                        <label for="type-name">Enter Type</label>
                        <input type="text" class="form-control" id="type"  name = "type" autofocus placeholder="Enter Type" value="{{ old('type') }}">
                        {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('parent_request') ? ' has-error has-feedback' : '' }}">
                        <label for="parentRequest">Enter Parent Request</label>
                        <input type="text" class="form-control" name="parent_request_id" id="parent-request-id" placeholder="Enter Parent Request" value="{{old('parent_request_id')}}">
                        {!! $errors->first('parent_request_id', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('sequence_no') ? ' has-error has-feedback' : '' }}">
                        <label for="sequenceNumber">Sequence Number</label>
                        <input type="text" class="form-control" name="sequence_no" id="sequence-no" placeholder="Enter Sequence Number" value="{{old('sequence_no')}}">
                        {!! $errors->first('sequence_no', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group" class="form-group has-feedback {{ $errors->has('description') ? ' has-error has-feedback' : '' }}">
                        <label for="Description">Enter Desciption</label>
                        <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description" value="{{old('description')}}">
                        {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('send_email_notification') ? ' has-error has-feedback' : '' }}">
                        <label for="Email-notification">Email Notification</label>
                        <input type="text" class="form-control" name="send_email_notification" id="send-email-notification" placeholder="Enter Email Notification" value="{{old('send_email_notification')}}" >
                        {!! $errors->first('send_email_notification', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('notify_to_supervisor') ? ' has-error has-feedback' : '' }}">
                        <label for="Supervisor">Enter Notification</label>
                        <input type="text" class="form-control" name="notify_to_supervisor" id="notify-to-supervisor" placeholder="Notify" value="{{old('notify_to_supervisor')}}">
                        {!! $errors->first('notify_to_supervisor', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="col-xs-4">


                    <div class="form-group has-feedback {{ $errors->has('repository') ? ' has-error has-feedback' : '' }}">
                        <label for="Createroute">Enter Repository</label>
                        <input type="text" class="form-control" name="repository" id="repository" placeholder="Enter Repository" value="{{old('repository')}}">
                        {!! $errors->first('repository', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="rows">
                <div class="box box-default collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Optional Fields</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <!-- form start -->


                    {{--                    {!! Form::open(['route' => ['admin.workflow.requesttype.store'], 'method' => 'post','id'=>'create-form']) !!}--}}
                    <div class="box-body">


                        <div class="col-xs-4">
                            <div class="form-group has-feedback {{ $errors->has('validity_days') ? ' has-error has-feedback' : '' }}">
                                <label for="Validity">Enter Validity</label>
                                <input type="text" class="form-control" name="validity_days" id="validity-days" placeholder="Enter Validity">
                                {!! $errors->first('validity_days', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('additional_emails_to_notify') ? ' has-error has-feedback' : '' }}">
                                <label for="Email-notification">Enter Additional Email</label>
                                <input type="text" class="form-control" name="additional_emails_to_notify" id="additional-emails-to-notify" placeholder="Enter Email">
                                {!! $errors->first('additional_emails_to_notify', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('initial_request_status_id') ? ' has-error has-feedback' : '' }}">
                                <label for="Requeststatus">Enter Initial Request</label>
                                <input type="text" class="form-control" name="initial_request_status_id" id="initial-request-status-id" placeholder="Enter Initial Request Status">
                               {!! $errors->first('initial_request_status_id', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group has-feedback {{ $errors->has('assign_to_supervisor') ? ' has-error has-feedback' : '' }}">
                                <label for="Assignsupervisor">Assign Supervisor</label>
                                <input type="text" class="form-control" name="assign_to_supervisor" id="assign-to-supervisor" placeholder="Enter Supervisor">
                                {!! $errors->first('assign_to_supervisor', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('update_request_route') ? ' has-error has-feedback' : '' }}">
                                <label for="Updateroute">Enter Update Route</label>
                                <input type="text" class="form-control" name="update_request_route" id="update-request-route" placeholder="Enter Update Route">
                                {!! $errors->first('update_request_route', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('create_request_route') ? ' has-error has-feedback' : '' }}">
                                <label for="Createroute">Enter Create Route</label>
                                <input type="text" class="form-control" name="create_request_route" id="reate-request-route" placeholder="Enter Create Route">
                                {!! $errors->first('create_request_route', '<span class="help-block">:message</span>') !!}
                            </div>
                            <input type="hidden" id="category-id" name="category_id">
                            <input type="hidden" id="old-type" name="type">
                        </div>
                        <div class="col-xs-4">

                            <div class="form-group has-feedback {{ $errors->has('closing_status_ids') ? ' has-error has-feedback' : '' }}">
                                <label for="Status">Enter Status</label>
                                <input type="text" class="form-control" name="closing_status_ids" id="closing-status-ids" placeholder="Enter Status">
                                {!! $errors->first('closing_status_ids', '<span class="help-block">:message</span>') !!}
                            </div>
                            <input type="hidden" id="category-id" name="category_id">
                            <input type="hidden" id="type" name="type">

                        </div>
                    </div>
                    <!-- /.box-body -->

                    {{--{!! Form::close() !!}--}}
                </div>
                <!-- /.box -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                </div>

            </div>

            {!! Form::close() !!}
        </div>
        <!-- /.box -->
    </div>

</div>
