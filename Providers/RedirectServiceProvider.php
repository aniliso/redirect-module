<?php

namespace Modules\Redirect\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Redirect\Composers\RedirectStatusComposer;
use Modules\Redirect\Events\Handlers\RegisterRedirectSidebar;
use Modules\Redirect\Http\Middleware\RedirectModuleMiddleware;

class RedirectServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;
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

        $this->app->extend('asgard.ModulesList', function($app) {
            array_push($app, 'redirect');
            return $app;
        });

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('Redirect', RegisterRedirectSidebar::class)
        );
    }

    public function boot()
    {
        $this->publishConfig('redirect', 'config');
        $this->publishConfig('redirect', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware(RedirectModuleMiddleware::class);

        view()->composer('redirect::admin.*', RedirectStatusComposer::class);
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

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Redirect\Repositories\ReportRepository',
            function () {
                $repository = new \Modules\Redirect\Repositories\Eloquent\EloquentReportRepository(new \Modules\Redirect\Entities\Report());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Redirect\Repositories\Cache\CacheReportDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Redirect\Repositories\RedirectRepository',
            function () {
                $repository = new \Modules\Redirect\Repositories\Eloquent\EloquentRedirectRepository(new \Modules\Redirect\Entities\Redirect());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Redirect\Repositories\Cache\CacheRedirectDecorator($repository);
            }
        );
// add bindings


    }
}
