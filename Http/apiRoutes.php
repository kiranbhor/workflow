
<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['middleware' => ['api.token','web']], function (Router $router) {

    /**
     * Workflow routes
     */

    $router->get('workflows/getAll', [
        'as' => 'api.workflow.workflows.get',
        'uses' => 'WorkflowController@getRequests',
        'middleware' =>'token-can:workflow.workflows.index'
    ]);


    $router->get('workflows/getDeleteWorkflow/{id}', [
        'as' => 'api.workflow.workflows.deleteWorkflow',
        'uses' => 'WorkflowController@getDeleteWorkflow',
        'middleware' =>'token-can:workflow.workflows.deleteWorkflow'
    ]);

    $router->delete('workflows/delete/{id}', [
        'as' => 'api.workflow.workflow.destroy',
        'uses' => 'WorkflowController@postDeleteWorkflow',
        'middleware' => 'token-can:workflow.workflows.destroy'
    ]);

    $router->post('workflows/destroySelected', [
        'as' => 'api.workflow.workflows.destroySelected',
        'uses' => 'WorkflowController@destroySelected',
        'middleware' =>'token-can:workflow.workflows.destroySelected'
    ]);


    $router->get('workflows/getReceivedRequest', [
        'as' => 'api.workflow.workflows.getReceivedRequest',
        'uses' => 'WorkflowController@getAssignedRequests',
        'middleware' =>'token-can:workflow.workflows.index'
    ]);


    $router->post('approveRequest', [
        'as' => 'api.workflow.workflows.postApproveRequest',
        'uses' => 'WorkflowController@postApproveRequest',
        'middleware' =>'token-can:workflow.workflows.postApproveRequest'
    ]);

    $router->post('rejectRequest', [
        'as' => 'api.workflow.workflows.postRejectRequest',
        'uses' => 'WorkflowController@postRejectRequest',
        'middleware' =>'token-can:workflow.workflows.postRejectRequest'
    ]);

    $router->post('forwardRequest', [
        'as' => 'api.workflow.workflows.postForwardRequest',
        'uses' => 'WorkflowController@postForwardRequest',
        'middleware' =>'token-can:workflow.workflows.postForwardRequest'
    ]);

});
