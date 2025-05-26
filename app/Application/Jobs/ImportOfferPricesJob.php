<?php

namespace App\Application\Jobs;

use Illuminate\Bus\Queueable;
use App\Domain\States\PricesState;
use App\Domain\States\OfferStateContext;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Infrastructure\Services\OfferApiService;
use App\Domain\Repositories\OfferPriceRepositoryInterface;
use App\Domain\Repositories\OfferProcessingRepositoryInterface;

class ImportOfferPricesJob implements ShouldQueue
{
    use Queueable;

    private const PART_NAME = 'prices';
    private const PART_EXPIRATION_SECONDS = 600;

    public function __construct(private string $reference)
    {
    }

    public function handle(
        OfferApiService $api,
        OfferPriceRepositoryInterface $priceRepository,
        OfferProcessingRepositoryInterface $processingRepository
    ) {
        $context = new OfferStateContext(new PricesState($api, $priceRepository));
        $context->handle($this->reference);

        $processingRepository->markPartAsCompleted($this->reference, self::PART_NAME);
        $processingRepository->setPartExpiry($this->reference, self::PART_EXPIRATION_SECONDS);
    }
}
