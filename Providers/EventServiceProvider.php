<?php

namespace Modules\Redirect\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Modules\Redirect\Events\Handlers\NotFoundHttpExceptionEvent;
use Modules\Redirect\Events\NotFoundHttpEventHandler;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NotFoundHttpEventHandler::class => [NotFoundHttpExceptionEvent::class]
    ];

    public function boot()
    {
        parent::boot();

        \Event::listen('404', function ($url){
           event(new NotFoundHttpEventHandler($url));
        });
    }
}
