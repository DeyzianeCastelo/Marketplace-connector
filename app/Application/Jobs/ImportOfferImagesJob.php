<?php

namespace App\Application\Jobs;

use App\Domain\Repositories\OfferImageRepositoryInterface;
use App\Domain\States\ImagesState;
use App\Domain\States\OfferStateContext;
use App\Infrastructure\Services\OfferApiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportOfferImagesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    public function __construct(private string $reference)
    {
    }

    public function handle(OfferApiService $api, OfferImageRepositoryInterface $imageRepository)
    {
        $context = new OfferStateContext(new ImagesState($api, $imageRepository));
        $context->handle($this->reference);
    }
}
