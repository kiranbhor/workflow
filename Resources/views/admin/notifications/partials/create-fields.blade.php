<div class="col-xs-6">
<div class="box-body">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Required Fields</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->


        {!! Form::open(['route' => ['admin.workflow.requesttype.store'], 'method' => 'post','id'=>'create-form']) !!}
        <div class="box-body">
            <div class="form-group has-feedback {{ $errors->has('type') ? ' has-error has-feedback' : '' }}">
                <label for="type-name">Type</label>
                <input type="text" class="form-control" id="type"  name = "type" autofocus placeholder="Enter Type" value="{{ old('name') }}">
                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group" class="form-group has-feedback {{ $errors->has('parent_request') ? ' has-error has-feedback' : '' }}">
                <label for="parentRequest">Enter Parent Request</label>
                <input type="text" class="form-control" name="parent_request" id="parent-request" placeholder="Enter Parent Request">
                {!! $errors->first('parent_request', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group" class="form-group has-feedback {{ $errors->has('sequence_no') ? ' has-error has-feedback' : '' }}">
                <label for="sequenceNumber">Sequence Number</label>
                <input type="text" class="form-control" name="sequence_no" id="sequence-no" placeholder="Enter Sequence Number">
                {!! $errors->first('sequence_no', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group" class="form-group has-feedback {{ $errors->has('task_default') ? ' has-error has-feedback' : '' }}">
                <label for="Description">Enter Desciption</label>
                <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group has-feedback {{ $errors->has('send_email_notification') ? ' has-error has-feedback' : '' }}">
                <label for="Email-notification">Email Notification</label>
                <input type="text" class="form-control" name="send_email_notification" id="send-email-notification" placeholder="Enter Email Notification">
                {!! $errors->first('send_email_notification', '<span class="help-block">:message</span>') !!}
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
<div class="col-xs-6">
    <div class="box-body">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Optional Fields</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->


        {!! Form::open(['route' => ['admin.workflow.requesttype.store'], 'method' => 'post','id'=>'create-form']) !!}
        <div class="box-body">
            <div class="form-group has-feedback {{ $errors->has('default_assignee_user_id') ? ' has-error has-feedback' : '' }}">
                <label for="type-name">Enter User Id</label>
                <input type="text" class="form-control" id="default-assignee-user-id"  name = "default_assignee_user_id" autofocus placeholder="Enter User Id" value="{{ old('default_assignee_user_id') }}">
                {!! $errors->first('default_assignee_user_id', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group" class="form-group has-feedback {{ $errors->has('default_designation_id') ? ' has-error has-feedback' : '' }}">
                <label for="parentRequest">Enter Designation Id</label>
                <input type="text" class="form-control" name="default_designation_id" id="default-designation-id" placeholder="Enter Designation Id">
                {!! $errors->first('default_designation_id', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group" class="form-group has-feedback {{ $errors->has('default_dept_id') ? ' has-error has-feedback' : '' }}">
                <label for="sequenceNumber">Enter Department Id</label>
                <input type="text" class="form-control" name="default_dept_id" id="default-dept-id" placeholder="Enter Department Id">
                {!! $errors->first('default_dept_id', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group" class="form-group has-feedback {{ $errors->has('notification_group_id') ? ' has-error has-feedback' : '' }}">
                <label for="Description">Enter Group Id</label>
                <input type="text" class="form-control" name="notification_group_id" id="notification-group-id" placeholder="Enter Group Id">
                {!! $errors->first('notification_group_id', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group has-feedback {{ $errors->has('closing_status_ids') ? ' has-error has-feedback' : '' }}">
                <label for="Email-notification">Enter Status</label>
                <input type="text" class="form-control" name="closing_status_ids" id="closing-status-ids" placeholder="Enter Status">
                {!! $errors->first('closing_status_ids', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group has-feedback {{ $errors->has('closing_status_ids') ? ' has-error has-feedback' : '' }}">
                <label for="Email-notification">Enter Status</label>
                <input type="text" class="form-control" name="closing_status_ids" id="closing-status-ids" placeholder="Enter Status">
                {!! $errors->first('closing_status_ids', '<span class="help-block">:message</span>') !!}
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