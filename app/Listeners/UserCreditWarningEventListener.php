<?php

namespace App\Listeners;

use App\Events\UserCreditWarningEvent;
use App\Notifications\UserCreditWarningNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreditWarningEventListener implements ShouldQueue
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
     * @param  UserCreditWarningEvent  $event
     * @return void
     */
    public function handle(UserCreditWarningEvent $event)
    {
        $event->user->notify(new UserCreditWarningNotification());
    }

    public function failed(UserCreditWarningEvent $event, $exception)
    {
        logger('User Credit Warning event faile - '.$event->user->id, [$exception]);
    }
}
