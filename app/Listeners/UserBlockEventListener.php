<?php

namespace App\Listeners;

use App\Events\UserBlockEvent;
use App\Jobs\DeleteBlockedUserRecords;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Jobs\Job;

class UserBlockEventListener
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
     * @param  UserBlockEvent  $event
     * @return void
     */
    public function handle(UserBlockEvent $event)
    {
        $time = Carbon::now()->addHours((int) env('INACTIVE_USER_DELETE','24'));

        DeleteBlockedUserRecords::dispatch($event->user)->delay($time);

    }

    /**
     * @param UserBlockEvent $event
     * @param $exception
     */
    public function failed(UserBlockEvent $event, $exception)
    {
        logger('User block event failure - '.$event->user->id, [$exception]);
    }
}
