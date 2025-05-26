<?php

namespace App\Application\Listeners;

use App\Application\Jobs\ImportOfferPricesJob;
use App\Domain\Events\OfferImagesImported;

class ImportOfferPricesListener
{
    public function handle(OfferImagesImported $event): void
    {
        dispatch(new ImportOfferPricesJob($event->reference));
    }
}
