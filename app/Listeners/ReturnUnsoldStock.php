<?php

namespace App\Listeners;

use App\Events\SessionClosed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReturnUnsoldStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SessionClosed $event): void
    {
        //
    }
}
