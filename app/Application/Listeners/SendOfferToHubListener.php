<?php

namespace App\Application\Listeners;

use App\Domain\Events\OfferPricesImported;
use App\Application\Jobs\SendOfferToHubJob;

class SendOfferToHubListener
{
    public function handle(OfferPricesImported $event): void
    {
        SendOfferToHubJob::dispatch($event->reference);
    }
}
