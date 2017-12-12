<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/workflow'], function (Router $router) {

    /**
     * Notification Routes
     */

    $router->bind('notification', function ($id) {
        return app('Modules\Workflow\Repositories\NotificationRepository')->find($id);
    });
    $router->get('notifications', [
        'as' => 'admin.workflow.notification.index',
        'uses' => 'NotificationController@index',
        'middleware' => 'can:workflow.notifications.index'
    ]);
    $router->get('notifications/create', [
        'as' => 'admin.workflow.notification.create',
        'uses' => 'NotificationController@create',
        'middleware' => 'can:workflow.notifications.create'
    ]);
    $router->post('notifications', [
        'as' => 'admin.workflow.notification.store',
        'uses' => 'NotificationController@store',
        'middleware' => 'can:workflow.notifications.create'
    ]);
    $router->get('notifications/{notification}/edit', [
        'as' => 'admin.workflow.notification.edit',
        'uses' => 'NotificationController@edit',
        'middleware' => 'can:workflow.notifications.edit'
    ]);
    $router->put('notifications/{notification}', [
        'as' => 'admin.workflow.notification.update',
        'uses' => 'NotificationController@update',
        'middleware' => 'can:workflow.notifications.edit'
    ]);
    $router->delete('notifications/{notification}', [
        'as' => 'admin.workflow.notification.destroy',
        'uses' => 'NotificationController@destroy',
        'middleware' => 'can:workflow.notifications.destroy'
    ]);

    /**
     * Request types Routes
     */
    $router->bind('requesttype', function ($id) {
        return app('Modules\Workflow\Repositories\RequestTypeRepository')->find($id);
    });
    $router->get('requesttypes', [
        'as' => 'admin.workflow.requesttype.index',
        'uses' => 'RequestTypeController@index',
        'middleware' => 'can:workflow.requesttypes.index'
    ]);
    $router->get('requesttypes/create', [
        'as' => 'admin.workflow.requesttype.create',
        'uses' => 'RequestTypeController@create',
        'middleware' => 'can:workflow.requesttypes.create'
    ]);
    $router->post('requesttypes', [
        'as' => 'admin.workflow.requesttype.store',
        'uses' => 'RequestTypeController@store',
        'middleware' => 'can:workflow.requesttypes.create'
    ]);
    $router->get('requesttypes/{requesttype}/edit', [
        'as' => 'admin.workflow.requesttype.edit',
        'uses' => 'RequestTypeController@edit',
        'middleware' => 'can:workflow.requesttypes.edit'
    ]);
    $router->put('requesttypes/{requesttype}', [
        'as' => 'admin.workflow.requesttype.update',
        'uses' => 'RequestTypeController@update',
        'middleware' => 'can:workflow.requesttypes.edit'
    ]);
    $router->delete('requesttypes/{requesttype}', [
        'as' => 'admin.workflow.requesttype.destroy',
        'uses' => 'RequestTypeController@destroy',
        'middleware' => 'can:workflow.requesttypes.destroy'
    ]);

    /**
     * Workflow Routes
     */


    $router->bind('workflow', function ($id) {
        return app('Modules\Workflow\Repositories\WorkflowRepository')->find($id);
    });
    $router->post('workflows/apply-transition/{workflow}', [
        'as' => 'admin.workflow.workflow.applytransition',
        'uses' => 'WorkflowController@applyTransition',
        'middleware' => 'can:workflow.workflows.apply-transition'
    ]);

    $router->get('workflows/myrequests', [
        'as' => 'admin.workflow.workflow.index',
        'uses' => 'WorkflowController@index',
        'middleware' => 'can:workflow.workflows.index'
    ]);
    $router->get('workflows/assigned-to-me', [
        'as' => 'admin.workflow.workflow.getAssignedRequests',
        'uses' => 'WorkflowController@getAssignedRequests',
        'middleware' => 'can:workflow.workflows.index'
    ]);
    $router->get('workflows/create', [
        'as' => 'admin.workflow.workflow.create',
        'uses' => 'WorkflowController@create',
        'middleware' => 'can:workflow.workflows.create'
    ]);
    $router->post('workflows', [
        'as' => 'admin.workflow.workflow.store',
        'uses' => 'WorkflowController@store',
        'middleware' => 'can:workflow.workflows.create'
    ]);
    $router->get('workflows/{workflow}/edit', [
        'as' => 'admin.workflow.workflow.edit',
        'uses' => 'WorkflowController@edit',
        'middleware' => 'can:workflow.workflows.edit'
    ]);
    $router->put('workflows/{workflow}', [
        'as' => 'admin.workflow.workflow.update',
        'uses' => 'WorkflowController@update',
        'middleware' => 'can:workflow.workflows.edit'
    ]);
    $router->delete('workflows/{workflow}', [
        'as' => 'admin.workflow.workflow.destroy',
        'uses' => 'WorkflowController@destroy',
        'middleware' => 'can:workflow.workflows.destroy'
    ]);
    $router->get('workflows/getRequestDetails/{id}', [
        'as' => 'admin.workflow.workflows.getRequestDetails',
        'uses' => 'WorkflowController@getRequestDetails',
        'middleware' =>'can:workflow.workflows.index'
    ]);

    $router->get('workflows/testDatatable', [
        'as' => 'admin.workflow.workflows.testDatatable',
        'uses' => 'WorkflowController@testDatatable',
        'middleware' =>'can:workflow.workflows.index'
    ]);

    $router->post('workflows/bulk', [
        'as' => 'workflows.bulk',
        'uses' => 'WorkflowController@bulk',
        'middleware' =>'can:workflow.workflows.edit'
    ]);

    $router->post('api/workflows', [
        'as' => 'api.workflows.index',
        'uses' => 'WorkflowController@getDatatable',
        'middleware' =>'can:workflow.workflows.edit'
    ]);


    /**
     * Workflowlog Routes
     */

    $router->bind('workflowlog', function ($id) {
        return app('Modules\Workflow\Repositories\WorkflowLogRepository')->find($id);
    });

    $router->get('workflowlogs', [
        'as' => 'admin.workflow.workflowlog.index',
        'uses' => 'WorkflowLogController@index',
        'middleware' => 'can:workflow.workflowlogs.index'
    ]);
    $router->get('workflowlogs/create', [
        'as' => 'admin.workflow.workflowlog.create',
        'uses' => 'WorkflowLogController@create',
        'middleware' => 'can:workflow.workflowlogs.create'
    ]);
    $router->post('workflowlogs', [
        'as' => 'admin.workflow.workflowlog.store',
        'uses' => 'WorkflowLogController@store',
        'middleware' => 'can:workflow.workflowlogs.create'
    ]);
    $router->get('workflowlogs/{workflowlog}/edit', [
        'as' => 'admin.workflow.workflowlog.edit',
        'uses' => 'WorkflowLogController@edit',
        'middleware' => 'can:workflow.workflowlogs.edit'
    ]);
    $router->put('workflowlogs/{workflowlog}', [
        'as' => 'admin.workflow.workflowlog.update',
        'uses' => 'WorkflowLogController@update',
        'middleware' => 'can:workflow.workflowlogs.edit'
    ]);
    $router->delete('workflowlogs/{workflowlog}', [
        'as' => 'admin.workflow.workflowlog.destroy',
        'uses' => 'WorkflowLogController@destroy',
        'middleware' => 'can:workflow.workflowlogs.destroy'
    ]);

    $router->get('workflowlogs/view/{id}', [
        'as' => 'admin.workflow.workflowlogs.view',
        'uses' => 'WorkflowLogController@view',
        'middleware' =>'can:workflow.workflowlogs.view'
    ]);

    /**
     * Workflowpriority Routes
     */

    $router->bind('workflowpriority', function ($id) {
        return app('Modules\Workflow\Repositories\WorkflowPriorityRepository')->find($id);
    });
    $router->get('workflowpriorities', [
        'as' => 'admin.workflow.workflowpriority.index',
        'uses' => 'WorkflowPriorityController@index',
        'middleware' => 'can:workflow.workflowpriorities.index'
    ]);
    $router->get('workflowpriorities/create', [
        'as' => 'admin.workflow.workflowpriority.create',
        'uses' => 'WorkflowPriorityController@create',
        'middleware' => 'can:workflow.workflowpriorities.create'
    ]);
    $router->post('workflowpriorities', [
        'as' => 'admin.workflow.workflowpriority.store',
        'uses' => 'WorkflowPriorityController@store',
        'middleware' => 'can:workflow.workflowpriorities.create'
    ]);
    $router->get('workflowpriorities/{workflowpriority}/edit', [
        'as' => 'admin.workflow.workflowpriority.edit',
        'uses' => 'WorkflowPriorityController@edit',
        'middleware' => 'can:workflow.workflowpriorities.edit'
    ]);
    $router->post('workflowpriorities/update', [
        'as' => 'admin.workflow.workflowpriority.update',
        'uses' => 'WorkflowPriorityController@update',
        'middleware' => 'can:workflow.workflowpriorities.edit'
    ]);
//    $router->put('workflowpriorities/{workflowpriority}', [
//        'as' => 'admin.workflow.workflowpriority.update',
//        'uses' => 'WorkflowPriorityController@update',
//        'middleware' => 'can:workflow.workflowpriorities.edit'
//    ]);
    $router->delete('workflowpriorities/{workflowpriority}', [
        'as' => 'admin.workflow.workflowpriority.destroy',
        'uses' => 'WorkflowPriorityController@destroy',
        'middleware' => 'can:workflow.workflowpriorities.destroy'
    ]);

    /**
     * Workflowstatus Routes
     */

    $router->bind('workflowstatus', function ($id) {
        return app('Modules\Workflow\Repositories\WorkflowStatusRepository')->find($id);
    });
    $router->get('workflowstatuses', [
        'as' => 'admin.workflow.workflowstatus.index',
        'uses' => 'WorkflowStatusController@index',
        'middleware' => 'can:workflow.workflowstatuses.index'
    ]);
    $router->get('workflowstatuses/create', [
        'as' => 'admin.workflow.workflowstatus.create',
        'uses' => 'WorkflowStatusController@create',
        'middleware' => 'can:workflow.workflowstatuses.create'
    ]);
    $router->post('workflowstatuses', [
        'as' => 'admin.workflow.workflowstatus.store',
        'uses' => 'WorkflowStatusController@store',
        'middleware' => 'can:workflow.workflowstatuses.create'
    ]);
    $router->get('workflowstatuses/{workflowstatus}/edit', [
        'as' => 'admin.workflow.workflowstatus.edit',
        'uses' => 'WorkflowStatusController@edit',
        'middleware' => 'can:workflow.workflowstatuses.edit'
    ]);
    $router->put('workflowstatuses/{workflowstatus}', [
        'as' => 'admin.workflow.workflowstatus.update',
        'uses' => 'WorkflowStatusController@update',
        'middleware' => 'can:workflow.workflowstatuses.edit'
    ]);

    $router->delete('workflowstatuses/{workflowstatus}', [
        'as' => 'admin.workflow.workflowstatus.destroy',
        'uses' => 'WorkflowStatusController@destroy',
        'middleware' => 'can:workflow.workflowstatuses.destroy'
    ]);
    $router->bind('notificationsubscription', function ($id) {
        return app('Modules\Workflow\Repositories\NotificationSubscriptionRepository')->find($id);
    });
    $router->get('notificationsubscriptions', [
        'as' => 'admin.workflow.notificationsubscription.index',
        'uses' => 'NotificationSubscriptionController@index',
        'middleware' => 'can:workflow.notificationsubscriptions.index'
    ]);
    $router->get('notificationsubscriptions/create', [
        'as' => 'admin.workflow.notificationsubscription.create',
        'uses' => 'NotificationSubscriptionController@create',
        'middleware' => 'can:workflow.notificationsubscriptions.create'
    ]);
    $router->post('notificationsubscriptions', [
        'as' => 'admin.workflow.notificationsubscription.store',
        'uses' => 'NotificationSubscriptionController@store',
        'middleware' => 'can:workflow.notificationsubscriptions.create'
    ]);
    $router->get('notificationsubscriptions/{notificationsubscription}/edit', [
        'as' => 'admin.workflow.notificationsubscription.edit',
        'uses' => 'NotificationSubscriptionController@edit',
        'middleware' => 'can:workflow.notificationsubscriptions.edit'
    ]);
    $router->put('notificationsubscriptions/{notificationsubscription}', [
        'as' => 'admin.workflow.notificationsubscription.update',
        'uses' => 'NotificationSubscriptionController@update',
        'middleware' => 'can:workflow.notificationsubscriptions.edit'
    ]);
    $router->delete('notificationsubscriptions/{notificationsubscription}', [
        'as' => 'admin.workflow.notificationsubscription.destroy',
        'uses' => 'NotificationSubscriptionController@destroy',
        'middleware' => 'can:workflow.notificationsubscriptions.destroy'
    ]);
    $router->bind('workflowsequence', function ($id) {
        return app('Modules\Workflow\Repositories\WorkflowSequenceRepository')->find($id);
    });
    $router->get('workflowsequences', [
        'as' => 'admin.workflow.workflowsequence.index',
        'uses' => 'WorkflowSequenceController@index',
        'middleware' => 'can:workflow.workflowsequences.index'
    ]);
    $router->get('workflowsequences/create', [
        'as' => 'admin.workflow.workflowsequence.create',
        'uses' => 'WorkflowSequenceController@create',
        'middleware' => 'can:workflow.workflowsequences.create'
    ]);
    $router->post('workflowsequences', [
        'as' => 'admin.workflow.workflowsequence.store',
        'uses' => 'WorkflowSequenceController@store',
        'middleware' => 'can:workflow.workflowsequences.create'
    ]);
    $router->get('workflowsequences/{workflowsequence}/edit', [
        'as' => 'admin.workflow.workflowsequence.edit',
        'uses' => 'WorkflowSequenceController@edit',
        'middleware' => 'can:workflow.workflowsequences.edit'
    ]);
    $router->put('workflowsequences/{workflowsequence}', [
        'as' => 'admin.workflow.workflowsequence.update',
        'uses' => 'WorkflowSequenceController@update',
        'middleware' => 'can:workflow.workflowsequences.edit'
    ]);
    $router->delete('workflowsequences/{workflowsequence}', [
        'as' => 'admin.workflow.workflowsequence.destroy',
        'uses' => 'WorkflowSequenceController@destroy',
        'middleware' => 'can:workflow.workflowsequences.destroy'
    ]);
// append



});
