<?php

namespace App\Application\Jobs;

use Illuminate\Bus\Queueable;
use App\Domain\States\ImagesState;
use App\Domain\States\OfferStateContext;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Infrastructure\Services\OfferApiService;
use App\Domain\Repositories\OfferImageRepositoryInterface;
use App\Domain\Repositories\OfferProcessingRepositoryInterface;

class ImportOfferImagesJob implements ShouldQueue
{
    use Queueable;

    private const PART_NAME = 'images';
    private const PART_EXPIRATION_SECONDS = 600;

    public function __construct(private string $reference)
    {
    }

    public function handle(
        OfferApiService $api,
        OfferImageRepositoryInterface $imageRepository,
        OfferProcessingRepositoryInterface $processingRepository
    ) {
        $context = new OfferStateContext(new ImagesState($api, $imageRepository));
        $context->handle($this->reference);

        $processingRepository->markPartAsCompleted($this->reference, self::PART_NAME);
        $processingRepository->setPartExpiry($this->reference, self::PART_EXPIRATION_SECONDS);
    }
}
