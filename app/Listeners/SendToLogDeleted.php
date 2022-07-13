<?php

namespace App\Listeners;

use App\Events\PostWasDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendToLogDeleted
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
     * @param  \App\Events\PostWasDeleted  $event
     * @return void
     */
    public function handle(PostWasDeleted $event)
    {
        \Log::info("Post was Created, Post name: $event->message");
    }
}
