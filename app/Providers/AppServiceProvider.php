<?php

namespace App\Providers;

use App\Models\LandLayer;
use App\Models\WorkOrder;
use App\Models\WorkOrdersPermit;
use App\Observers\LandLayerObserver;
use App\Observers\WorkOrderObserver;
use App\Models\WorkOrdersPermitsFine;
use Illuminate\Support\ServiceProvider;
use App\Models\WorkOrdersPermitsExtension;
use App\Observers\WorkOrdersPermitObserver;
use App\Observers\WorkOrdersPermitsFineObserver;
use App\Observers\WorkOrdersPermitsExtensionObserver;
use App\Services\NotificationService;
use App\Jobs\SendNotification;


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
            return new NotificationService();
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


$this->app->bindMethod([ProcessPodcast::class, 'handle'], function (ProcessPodcast $job, Application $app) {
    return $job->handle($app->make(AudioProcessor::class));
});
        WorkOrdersPermitsExtension::observe(WorkOrdersPermitsExtensionObserver::class);
        WorkOrdersPermitsFine::observe(WorkOrdersPermitsFineObserver::class);
        WorkOrdersPermit::observe(WorkOrdersPermitObserver::class);
        LandLayer::observe(LandLayerObserver::class);
        WorkOrder::observe(WorkOrderObserver::class);
    }
}
