<?php

namespace App\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Application\Jobs\ImportOfferDetailsJob;
use App\Infrastructure\Services\OfferApiService;
use App\Domain\Repositories\OfferProcessingRepositoryInterface;

class ProcessOffersPageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(protected int $page)
    {
    }

    public function handle(
        OfferApiService $api,
        OfferProcessingRepositoryInterface $processingRepository
    ) {
        Log::info("Processando página {$this->page} de anúncios.");

        $response = $api->getOffers($this->page);

        if ($response->failed()) {
            Log::error("Falha ao buscar página {$this->page} da API do Marketplace.");
            return;
        }

        $data = $response->json();

        $offers = $data['data']['offers'] ?? [];

        $count = count($offers);
        $processingRepository->setPageProcessingCount($this->page, $count);

        Log::info("Encontrados " . $count . " anúncios na página {$this->page}.");

        foreach ($offers as $reference) {
            Log::info("Agendando processamento de detalhes do anúncio {$reference}.");
            dispatch(new ImportOfferDetailsJob($reference, $this->page));
        }

        $processingRepository->setLastPaginationPage($data['pagination']['total_pages'] ?? $this->page);
    }
}
