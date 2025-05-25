<?php

namespace App\Application\Jobs;

use Illuminate\Bus\Queueable;
use App\Domain\States\DetailsState;
use Illuminate\Queue\SerializesModels;
use App\Domain\States\OfferStateContext;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domain\Repositories\OfferRepositoryInterface;

class ImportOfferDetailsJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private string $reference)
    {
    }

    public function handle(OfferRepositoryInterface $offerRepository)
    {
        $context = new OfferStateContext(new DetailsState($offerRepository));
        $context->handle($this->reference);
    }
}
