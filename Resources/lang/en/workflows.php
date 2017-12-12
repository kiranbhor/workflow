<?php

return [
    'list resource' => 'List workflows',
    'create resource' => 'Create workflows',
    'edit resource' => 'Edit workflows',
    'destroy resource' => 'Destroy workflows',
    'title' => [
        'workflows' => 'My Requests ',
        'create workflow' => 'Create a workflow',
        'edit workflow' => 'Edit a workflow',
        'received requests' => 'Received Requests'
    ],
    'button' => [
        'create workflow' => 'Create a workflow',
    ],
    'table' => [
    ],
    'form' => [
    ],
    'messages' => [
        'delete' => 'Delete Workflow',
    ],
    'validation' => [
    ],

    //Order workflow transition
    'Order'=>[
        'admin_approved' => [
            'html' => '<span class="btn btn-flat btn-default"><i class="glyphicon glyphicon-ok"></i>Approve</span>',
            'text' => 'Approve'
        ],
        'accountant_approved' => [
            'html' => '<span class="btn btn-flat btn-default"><i class="glyphicon glyphicon-ok"></i>Approve</span>',
            'text' => 'Approve'
        ],
        'admin_rejected' => [
            'html' =>'<span class="btn btn-flat btn-default"><i class="glyphicon glyphicon-ok"></i>Reject</span>',
            'text' =>'Reject'
        ],
        'account_rejected' => [
            'html' => '<span class="btn btn-flat btn-default"><i class="glyphicon glyphicon-ok"></i>Reject</span>',
            'text' => 'Reject'
        ],
        'create_invoice' => [
            'html' => '<span class="btn btn-flat btn-default"><i class="glyphicon glyphicon-ok"></i>Create Invoice</span>',
            'text' => 'Create Invoice'
        ],
        're_open' => [
            'html' => '<span class="btn btn-flat btn-default"><i class="glyphicon glyphicon-ok"></i>Reopen</span>',
            'text' => 'Re-open'
        ],
        'invoice'=>[
            'html' => '<span class="btn btn-flat btn-default"><i class="glyphicon glyphicon-ok"></i>Generate Invoice</span>',
            'text' => 'Generate Invoice'
        ]
    ]
];

