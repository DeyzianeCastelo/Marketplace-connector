<?php

namespace App\Application\Jobs;

use Illuminate\Bus\Queueable;
use App\Domain\States\DetailsState;
use App\Domain\States\OfferStateContext;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Infrastructure\Services\OfferApiService;
use App\Domain\Repositories\OfferRepositoryInterface;
use App\Domain\Repositories\OfferProcessingRepositoryInterface;

class ImportOfferDetailsJob implements ShouldQueue
{
    use Queueable;

    private const PART_NAME = 'details';
    private const PART_EXPIRATION_SECONDS = 600;
    private const CHECK_DELAY_SECONDS = 5;

    public function __construct(private string $reference, private int $page)
    {
    }

    public function handle(
        OfferApiService $api,
        OfferRepositoryInterface $offerRepository,
        OfferProcessingRepositoryInterface $processingRepository
    ) {
        $context = new OfferStateContext(new DetailsState($api, $offerRepository));
        $context->handle($this->reference);

        $processingRepository->markPartAsCompleted($this->reference, self::PART_NAME);
        $processingRepository->setPartExpiry($this->reference, self::PART_EXPIRATION_SECONDS);

        dispatch(new CheckOfferPartsCompletionJob($this->reference, $this->page))
            ->delay(now()->addSeconds(self::CHECK_DELAY_SECONDS));
    }
}
