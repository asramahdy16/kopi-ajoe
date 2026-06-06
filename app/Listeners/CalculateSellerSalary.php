<?php

namespace App\Listeners;

use App\Events\SellerCheckedOut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateSellerSalary
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
    public function handle(SellerCheckedOut $event): void
    {
        //
    }
}
