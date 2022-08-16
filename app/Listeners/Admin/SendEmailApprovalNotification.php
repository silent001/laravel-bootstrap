<?php

namespace App\Listeners\Admin;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Role;
use App\Models\User;
use App\Notifications\Admin\NewUser;

class SendEmailApprovalNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $admins = User::where('role_id', '>', Role::IS_USER)->get();
        foreach ( $admins as $admin ) {
            if ($admin) {
                $admin->notify(new NewUser($user));
            }
        }
    }
}
