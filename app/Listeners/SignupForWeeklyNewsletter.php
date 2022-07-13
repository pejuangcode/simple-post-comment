<?php

namespace App\Listeners;

use App\Events\PostWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Registered;
use Newsletter;

class SignupForWeeklyNewsletter
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
     * @param  \App\Events\PostWasCreated  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;

        if ( ! Newsletter::isSubscribed($user->email) ) {
            Newsletter::subscribePending($user->email);
            \Log::info("Thanks For Subscribe". $user->email);
        }
        
    }
}
