<?php

namespace App\Listeners\Auth;

use App\Events\Auth\PasswordChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Auth\PasswordChangeNotification;

class SendPasswordChangeMail
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
     * @param  \App\Events\Auth\PasswordChange  $event
     * @return void
     */
    public function handle(PasswordChange $event)
    {
        $user = $event->user;
        $user->notify(new PasswordChangeNotification($user));
    }
}
