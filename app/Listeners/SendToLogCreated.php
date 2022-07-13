<?php

namespace App\Listeners;

use App\Events\PostWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendToLogCreated
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
    public function handle(PostWasCreated $event)
    {
        $post = $event->post;
        \Log::info("Post was Created, product name: $post->body");
    }
}
