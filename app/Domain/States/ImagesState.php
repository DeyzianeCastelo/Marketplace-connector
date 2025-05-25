<?php

namespace App\Domain\States;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Domain\Entities\OfferImage as DomainOfferImage;
use App\Domain\Events\OfferImagesImported;
use App\Infrastructure\Eloquent\Models\Offer as EloquentOffer;
use App\Domain\Repositories\OfferImageRepositoryInterface;

class ImagesState implements OfferStateInterface
{
    public function __construct(private OfferImageRepositoryInterface $imageRepository)
    {
    }


    public function handle(string $reference): void
    {
        Log::info("Buscando imagens do anúncio {$reference}.");
        $response = Http::get("http://host.docker.internal:3000/offers/{$reference}/images");

        if ($response->failed()) {
            Log::error("Erro ao buscar imagens do anúncio {$reference}.");
            return;
        }

        $offer = EloquentOffer::where('reference', $reference)->first();

        $imageList = $response->json()['data']['images'] ?? [];

        foreach ($imageList as $imageData) {
            $image = new DomainOfferImage(
                url: $imageData['url'],
                offerReference: $offer->id
            );
            $this->imageRepository->save($image);
            Log::info("Imagem salva para {$reference}: {$imageData['url']}");
        }
        event(new OfferImagesImported($reference, $imageList));
    }
}
