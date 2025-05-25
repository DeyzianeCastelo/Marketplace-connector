<?php

namespace App\Domain\States;

use Illuminate\Support\Facades\Log;
use App\Domain\Events\OfferPricesImported;
use App\Infrastructure\Services\OfferApiService;
use App\Domain\Entities\OfferPrice as DomainOfferPrice;
use App\Domain\Repositories\OfferPriceRepositoryInterface;
use App\Infrastructure\Eloquent\Models\Offer as EloquentOffer;

class PricesState implements OfferStateInterface
{
    public function __construct(
        private OfferApiService $api,
        private OfferPriceRepositoryInterface $priceRepository
    ) {
    }

    public function handle(string $reference): void
    {
        Log::info("Buscando preços do anúncio {$reference}.");

        $response = $this->api->getOfferPrices($reference);

        if ($response->failed()) {
            Log::error("Erro ao buscar preços do anúncio {$reference}.");
            return;
        }

        $offer = EloquentOffer::where('reference', $reference)->first();

        $priceData = $response->json()['data'] ?? null;

        $price = new DomainOfferPrice(
            price: $priceData['price'],
            offerReference: $offer->id,
        );

        $this->priceRepository->save($price);
        Log::info("Preço salvo para {$reference}: {$priceData['price']}");

        event(new OfferPricesImported($reference, $priceData));
    }
}
