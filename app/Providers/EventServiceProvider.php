<?php

namespace App\Providers;
// events
use Illuminate\Auth\Events\Registered;
use App\Events\UserLogsEvent;
//listeners
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\UserLogsListener;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserLogsEvent::class  => [
            UserLogsListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
