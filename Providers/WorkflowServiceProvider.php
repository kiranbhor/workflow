<?php

namespace Modules\Workflow\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Workflow\Events\Handlers\RegisterWorkflowSidebar;
use Modules\Workflow\Composers\NotificationViewComposer;

class WorkflowServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterWorkflowSidebar::class);
	$this->registerViewComposers();
    }

    public function boot()
    {
        $this->publishConfig('workflow', 'config');
        $this->publishConfig('workflow', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Register view composers
     */
    private function registerViewComposers() {
        view()->composer('partials.top-nav', NotificationViewComposer:: class);

        view()->composer('layouts.master', function ($view) {
            $listenPath = config('broadcasting.socket_io.protocol') . '://' . config('broadcasting.socket_io.server_ip') . ':' . config('broadcasting.socket_io.server_port');
            $view->with('listenPath', $listenPath);
        });

    }
    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Workflow\Repositories\RequestTypeRepository',
            function () {
                $repository = new \Modules\Workflow\Repositories\Eloquent\EloquentRequestTypeRepository(new \Modules\Workflow\Entities\RequestType());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Workflow\Repositories\Cache\CacheRequestTypeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Workflow\Repositories\WorkflowPriorityRepository',
            function () {
                $repository = new \Modules\Workflow\Repositories\Eloquent\EloquentWorkflowPriorityRepository(new \Modules\Workflow\Entities\WorkflowPriority());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Workflow\Repositories\Cache\CacheWorkflowPriorityDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Workflow\Repositories\WorkflowStatusRepository',
            function () {
                $repository = new \Modules\Workflow\Repositories\Eloquent\EloquentWorkflowStatusRepository(new \Modules\Workflow\Entities\WorkflowStatus());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Workflow\Repositories\Cache\CacheWorkflowStatusDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Workflow\Repositories\WorkflowRepository',
            function () {
                $repository = new \Modules\Workflow\Repositories\Eloquent\EloquentWorkflowRepository(new \Modules\Workflow\Entities\Workflow());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Workflow\Repositories\Cache\CacheWorkflowDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Workflow\Repositories\WorkflowLogRepository',
            function () {
                $repository = new \Modules\Workflow\Repositories\Eloquent\EloquentWorkflowLogRepository(new \Modules\Workflow\Entities\WorkflowLog());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Workflow\Repositories\Cache\CacheWorkflowLogDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Workflow\Repositories\NotificationRepository',
            function () {
                $repository = new \Modules\Workflow\Repositories\Eloquent\EloquentNotificationRepository(new \Modules\Workflow\Entities\Notification());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Workflow\Repositories\Cache\CacheNotificationDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Workflow\Repositories\NotificationSubscriptionRepository',
            function () {
                $repository = new \Modules\Workflow\Repositories\Eloquent\EloquentNotificationSubscriptionRepository(new \Modules\Workflow\Entities\NotificationSubscription());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Workflow\Repositories\Cache\CacheNotificationSubscriptionDecorator($repository);
            }
        );
// add bindings







    }
}
