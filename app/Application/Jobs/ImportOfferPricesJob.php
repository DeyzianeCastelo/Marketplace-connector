<?php

namespace App\Application\Jobs;

use App\Domain\States\PricesState;
use Illuminate\Queue\SerializesModels;
use App\Domain\States\OfferStateContext;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Domain\Repositories\OfferPriceRepositoryInterface;
use App\Infrastructure\Services\OfferApiService;

class ImportOfferPricesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    public function __construct(private string $reference)
    {
    }

    public function handle(OfferApiService $api, OfferPriceRepositoryInterface $priceRepository)
    {
        $context = new OfferStateContext(new PricesState($api, $priceRepository));
        $context->handle($this->reference);
    }
}
