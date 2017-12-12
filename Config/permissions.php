<?php

return [

    'workflow.module' =>[
        'index' => 'Show Workflow Module',
    ],
    'workflow.requesttypes' => [
        'index' => 'workflow::requesttypes.list resource',
        'create' => 'workflow::requesttypes.create resource',
        'edit' => 'workflow::requesttypes.edit resource',
        'destroy' => 'workflow::requesttypes.destroy resource',
    ],
    'workflow.workflowpriorities' => [
        'index' => 'workflow::workflowpriorities.list resource',
        'create' => 'workflow::workflowpriorities.create resource',
        'edit' => 'workflow::workflowpriorities.edit resource',
        'destroy' => 'workflow::workflowpriorities.destroy resource',
    ],
    'workflow.workflowstatuses' => [
        'index' => 'workflow::workflowstatuses.list resource',
        'create' => 'workflow::workflowstatuses.create resource',
        'edit' => 'workflow::workflowstatuses.edit resource',
        'destroy' => 'workflow::workflowstatuses.destroy resource',
    ],
    'workflow.workflows' => [
        'index' => 'workflow::workflows.list resource',
        'create' => 'workflow::workflows.create resource',
        'edit' => 'workflow::workflows.edit resource',
        'destroy' => 'workflow::workflows.destroy resource',
        'getAssignedRequest' =>'Show Received Reuqests',
        'getReceivedRequest' => 'Get Received Requests',
        'getRequestDetails' => 'Get Request Details',
        'postApproveRequest' => 'Approve Reuqests',
        'postRejectRequest' => 'Reject Requests',
        'postForwardRequest' => 'Forward Request',
        'apply-transition' => 'Approval'

    ],
    'workflow.workflowlogs' => [
        'index' => 'workflow::workflowlogs.list resource',
        'create' => 'workflow::workflowlogs.create resource',
        'edit' => 'workflow::workflowlogs.edit resource',
        'destroy' => 'workflow::workflowlogs.destroy resource',
    ],
    'workflow.notifications' => [
        'index' => 'workflow::notifications.list resource',
        'create' => 'workflow::notifications.create resource',
        'edit' => 'workflow::notifications.edit resource',
        'destroy' => 'workflow::notifications.destroy resource',
    ],
    'workflow.notificationsubscriptions' => [
        'index' => 'workflow::notificationsubscriptions.list resource',
        'create' => 'workflow::notificationsubscriptions.create resource',
        'edit' => 'workflow::notificationsubscriptions.edit resource',
        'destroy' => 'workflow::notificationsubscriptions.destroy resource',
    ],
    'workflow.workflowsequences' => [
        'index' => 'workflow::workflowsequences.list resource',
        'create' => 'workflow::workflowsequences.create resource',
        'edit' => 'workflow::workflowsequences.edit resource',
        'destroy' => 'workflow::workflowsequences.destroy resource',
    ],
// append








];
