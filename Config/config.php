<?php

return [
    'name' => 'Workflow',

    'notification'=> [
        'max_notification_to_show' => 10,
        ],

    'request_status' => [
        'pending' => 1,
        'approved' => 2,
        'rejected' => 3,
        'forwarded' => 4,
        'cancelled' => 5,
        'stagged' => 6,
    ],

    'task_status' => [
		'Assigned' => 7,
		'InProgress' => 8,
		'Completed' => 9,
		'OnHold' => 10,
		'NotStarted' => 11,
	],

    'request_type_ids' => [
        'LateSigin' => 1,
        'PreviousDaySignout' => 2,
        'SignInDelay' => 3,
        'Task' => 4,
        'Leave' => 5,
        'BuildingPlan' =>7,
        'InfrastructureServices' => 9,
        'DelayedInPunchout'=>10,
        'Event' =>11,
        'CancelLeave' => 12,
    ],

    'request_types' => [
        'LateSigin' => 'LateSigin',
        'PreviousDaySignout' => 'PreviousDaySignout',
        'SignInDelay' => 'SignInDelay',
        'Task' => 'Task',
        'Leave' => 'Leave Request',
        'BuildingPlan' =>'BuildingPlan',
        'InfrastructureServices' => 'InfrastructureServices',
        'DelayedInPunchout'=>'DelayedInPunchout',
        'Event' =>'Event',
        'CancelLeave' => 'CancelLeave',
    ],
];
