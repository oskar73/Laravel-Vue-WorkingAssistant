<?php

namespace App\Providers;

use App\Models\Website as Tenant;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TenancyProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->configureQueue();
        } else {
            $this->configureRequests();
            $this->setEnvironmentForTenant();
        }
    }

    public function configureRequests(): bool
    {
        $this->exchangeHost();

        $domain = request()->getHttpHost();

        $tenant = Tenant::where('domain', $domain)
            ->where('status', 'active')
            ->first();

        if ($tenant) {
            $tenant->configure()->use();

            $tenant->load('pages');

            if ($tenant->status_by_owner == 'maintenance') {
                abort(503);
            } elseif ($tenant->status_by_owner != 'active') {
                abort(404);
            }

            View::share('website', $tenant);

            return true;
        }

        return false;
    }

    private function setEnvironmentForTenant()
    {
        Queue::createPayloadUsing(function () {
            return $this->app['tenant'] ? ['tenant_id' => $this->app['tenant']->id] : [];
        });
    }

    public function configureQueue()
    {
        $this->app['events']->listen(JobProcessing::class, function ($event) {
            if (isset($event->job->payload()['tenant_id'])) {
                Tenant::find($event->job->payload()['tenant_id'])->configure()->use();
            }
        });
    }

    private function exchangeHost()
    {
        $request = request();
        if ($request->headers->has('User-Custom-Domain')) {
            $domain = $request->header('User-Custom-Domain');
            $request->headers->remove('HOST');
            $request->headers->set('HOST', $domain);
        }
    }
}
