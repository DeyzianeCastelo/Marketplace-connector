<?php

namespace App\Application\Listeners;

use App\Application\Jobs\ImportOfferPricesJob;
use App\Domain\Events\OfferImagesImported;

class ImportOfferPricesListener
{
    public function handle(OfferImagesImported $event): void
    {
        ImportOfferPricesJob::dispatch($event->reference);
    }
}
