<?php

namespace App\Listeners;

use App\Events\SalaryApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifySellerSalaryApproved
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
    public function handle(SalaryApproved $event): void
    {
        //
    }
}
