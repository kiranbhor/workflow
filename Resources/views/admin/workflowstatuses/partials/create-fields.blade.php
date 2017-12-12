<div class="box-body">

    {!! Former::select('request_type_id')
            ->addOption(null)
            ->fromQuery($requestTypes)
            ->label('Request Type')
            ->data_placeholder('Request Type')
            ->placeholder('Workflow Type')
    !!}

    {!! Former::text('status') !!}

    {!! Former::text('worklow_place') !!}

    {!! Former::text('sequence_no') !!}


    {!! Former::select('assign_to_employee')
            ->addOption(null)
            ->fromQuery($employees,'first_name','id')
            ->data_placeholder('Assign To Employee')
    !!}

    {!! Former::select('assign_to_designation')
            ->addOption(null)
            ->fromQuery($designations,'designation','id')
            ->data_placeholder('Assign to Designation')
    !!}

    {!! Former::select('assign_to_department')
            ->addOption(null)
            ->fromQuery($departments,'name','id')
            ->data_placeholder('Assign To Department')
    !!}

    {!! Former::text('label_class') !!}

    {!! Former::checkbox('is_closing_status') !!}

</div>