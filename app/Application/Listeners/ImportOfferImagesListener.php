<?php

namespace App\Application\Listeners;

use App\Domain\Events\OfferImported;
use App\Application\Jobs\ImportOfferImagesJob;

class ImportOfferImagesListener
{
    public function handle(OfferImported $event): void
    {
        ImportOfferImagesJob::dispatch($event->reference);
    }
}
