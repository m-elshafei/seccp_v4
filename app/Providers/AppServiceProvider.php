<?php

namespace App\Providers;

use App\Jobs\SendNotification;
use App\Models\LandLayer;
use App\Models\WorkOrder;
use App\Models\WorkOrdersPermit;
use App\Models\WorkOrdersPermitsExtension;
use App\Models\WorkOrdersPermitsFine;
use App\Observers\LandLayerObserver;
use App\Observers\WorkOrderObserver;
use App\Observers\WorkOrdersPermitObserver;
use App\Observers\WorkOrdersPermitsExtensionObserver;
use App\Observers\WorkOrdersPermitsFineObserver;
use App\Services\Notifications\NotificationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(NotificationService::class, function ($app) {
            return new NotificationService;
        });

        // Bind the method of SendNotification to use NotificationService
        $this->app->bindMethod([SendNotification::class, 'handle'], function (SendNotification $job, Application $app) {
            return $job->handle(
                $app->make(NotificationService::class)
            );
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bindMethod([SendNotification::class, 'handle'], function (SendNotification $job, Application $app) {
            return $job->handle($app->make(NotificationService::class));
        });
        WorkOrdersPermitsExtension::observe(WorkOrdersPermitsExtensionObserver::class);
        WorkOrdersPermitsFine::observe(WorkOrdersPermitsFineObserver::class);
        WorkOrdersPermit::observe(WorkOrdersPermitObserver::class);
        LandLayer::observe(LandLayerObserver::class);
        WorkOrder::observe(WorkOrderObserver::class);
    }
}
