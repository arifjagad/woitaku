<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use  App\Models\Member;

class CreateMember
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
    public function handle(UserRegistered $event)
    {
        $member = new Member([
            
        ]);
    
        $event->user->member()->save($member);
    }
}
