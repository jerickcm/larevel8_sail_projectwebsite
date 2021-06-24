<?php

namespace App\Listeners;

use App\Events\UserLogsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\AdminUsersLogs;


class UserLogsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserLogsEvent  $event
     * @return void
     */
    public function handle(UserLogsEvent $event)
    {
        AdminUsersLogs::create([
            'user_id' => $event->user_id,
            'type' => $event->type,
            'meta' => $event->meta,
        ]);
    }
}
