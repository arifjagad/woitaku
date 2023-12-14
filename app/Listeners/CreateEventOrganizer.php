<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use  App\Models\EventOrganizer;

class CreateEventOrganizer
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
        $eventOrganizer = new EventOrganizer([
            
        ]);
    
        $event->user->eventOrganizer()->save($eventOrganizer);
    }
}
