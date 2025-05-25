<?php

namespace App\Application\Jobs;

use App\Domain\States\PricesState;
use Illuminate\Queue\SerializesModels;
use App\Domain\States\OfferStateContext;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Domain\Repositories\OfferPriceRepositoryInterface;

class ImportOfferPricesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    public function __construct(private string $reference)
    {
    }

    public function handle(OfferPriceRepositoryInterface $priceRepository)
    {
        $context = new OfferStateContext(new PricesState($priceRepository));
        $context->handle($this->reference);
    }
}
