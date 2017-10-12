<?php

namespace Modules\Workflow\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterWorkflowSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
         $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('workflow::notifications.title.module heading'), function (Item $item) {
                $item-> icon('fa fa-copy');
                $item->weight(0);
                $item->authorize(
                     /* append */
                );

                $item->item('Received Requests', function (Item $item) {
                    $item->icon('fa fa-arrow-down');
                    $item->weight(0);
                    $item->route('admin.workflow.workflow.getAssignedRequests');
                    $item->authorize(
                        $this->auth->hasAccess('workflow.workflows.index')
                    );
                });


                $item->item(trans('workflow::notifications.title.notifications'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.workflow.notification.create');
                    $item->route('admin.workflow.notification.index');
                    $item->authorize(
                        $this->auth->hasAccess('workflow.notifications.index')
                    );
                });
                $item->item(trans('workflow::requesttypes.title.requesttypes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.workflow.requesttype.create');
                    $item->route('admin.workflow.requesttype.index');
                    $item->authorize(
                        $this->auth->hasAccess('workflow.requesttypes.index')
                    );
                });
                $item->item(trans('workflow::workflows.title.workflows'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.workflow.workflow.create');
                    $item->route('admin.workflow.workflow.index');
                    $item->authorize(
                        $this->auth->hasAccess('workflow.workflows.index')
                    );
                });
                $item->item(trans('workflow::workflowlogs.title.workflowlogs'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.workflow.workflowlog.create');
                    $item->route('admin.workflow.workflowlog.index');
                    $item->authorize(
                        $this->auth->hasAccess('workflow.workflowlogs.index')
                    );
                });
                $item->item(trans('workflow::workflowpriorities.title.workflowpriorities'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.workflow.workflowpriority.create');
                    $item->route('admin.workflow.workflowpriority.index');
                    $item->authorize(
                        $this->auth->hasAccess('workflow.workflowpriorities.index')
                    );
                });
                $item->item(trans('workflow::workflowstatuses.title.workflowstatuses'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.workflow.workflowstatus.create');
                    $item->route('admin.workflow.workflowstatus.index');
                    $item->authorize(
                        $this->auth->hasAccess('workflow.workflowstatuses.index')
                    );
                });
                $item->item(trans('workflow::notificationsubscriptions.title.notificationsubscriptions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.workflow.notificationsubscription.create');
                    $item->route('admin.workflow.notificationsubscription.index');
                    $item->authorize(
                        $this->auth->hasAccess('workflow.notificationsubscriptions.index')
                    );
                });


            });
        });

        return $menu;
    }
}
