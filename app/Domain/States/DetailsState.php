<?php

namespace App\Domain\States;

use App\Domain\Entities\Offer;
use Illuminate\Support\Facades\Log;
use App\Domain\Events\OfferImported;
use App\Infrastructure\Services\OfferApiService;
use App\Domain\Repositories\OfferRepositoryInterface;

class DetailsState implements OfferStateInterface
{
    public function __construct(
        private OfferApiService $api,
        private OfferRepositoryInterface $offerRepository
    ) {
    }

    public function handle(string $reference): void
    {
        Log::info("Buscando detalhes do anúncio {$reference}.");

        $response = $this->api->getOfferDetails($reference);

        if ($response->failed()) {
            Log::error("Erro ao buscar detalhes do anúncio {$reference}.");
            return;
        }

        $data = data_get($response->json(), 'data', []);

        $offer = new Offer(
            reference: $data['id'],
            title: $data['title'],
            description: $data['description'],
            status: $data['status'],
            stock: $data['stock']
        );

        $this->offerRepository->save($offer);

        $persistedOffer = $this->offerRepository->findByReference($offer->reference);

        Log::info("Detalhes do anúncio {$reference} obtidos com sucesso.");

        event(new OfferImported($persistedOffer->reference, $data));
    }
}
