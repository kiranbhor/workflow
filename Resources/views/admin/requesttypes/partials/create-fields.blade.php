<div class="row">
    <div class="col-md-6">
        {!!
            Former::text('type')
        !!}
    </div>
    <div class="col-md-6">
        {!!
            Former::select('parent_request_id')
            ->label('Parent Request')
            ->addOption(null)
            ->data_placeholder('Parent Request')
            ->fromQuery($requestTypes,'type','id')
        !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!!
            Former::text('sequence_no')
        !!}
    </div>
    <div class="col-md-6">
        {!!
            Former::text('description')
        !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!!
            Former::select('default_dept_id')
            ->label('Default Department')
            ->addOption(null)
            ->data_placeholder('Department')
            ->fromQuery($departments,'name','id')
        !!}
    </div>
    <div class="col-md-6">
        {!!
            Former::select('default_designation_id')
            ->label('Default Designation')
            ->addOption(null)
            ->data_placeholder('Designation')
            ->fromQuery($designations,'designation','id')
        !!}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {!!
            Former::select('initial_request_status_id')
            ->label('Default Status')
            ->addOption(null)
            ->data_placeholder('Initial Status')
            ->fromQuery($requestStatus,'status','id')
        !!}
    </div>
    <div class="col-md-6">
        {!!
            Former::select('closing_status_ids')
            ->label('Closing Status')
            ->addOption(null)
            ->data_placeholder('Closing Status')
            ->fromQuery($requestStatus,'status','id')
        !!}
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        {!!
           Former::checkbox('show_approve_btn')
            ->label('Approve')
        !!}

        {!!
           Former::checkbox('show_reject_btn')
            ->label('Reject')
        !!}

        {!!
           Former::checkbox('show_forward_btn')
            ->label('Forward')
        !!}


        {!!
           Former::checkbox('show_cancel_btn')
            ->label('Reject')
        !!}
    </div>
</div>





