<?php

namespace App\Infrastructure\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class OfferApiService
{
    private string $baseUrl = 'http://host.docker.internal:3000';

    public function getOffers(int $page = 1): Response
    {
        return Http::get("{$this->baseUrl}/offers", [
            'page' => $page,
        ]);
    }

    public function getOfferDetails(string $reference): Response
    {
        return Http::get("{$this->baseUrl}/offers/{$reference}");
    }

    public function getOfferImages(string $reference): Response
    {
        return Http::get("{$this->baseUrl}/offers/{$reference}/images");
    }

    public function getOfferPrices(string $reference): Response
    {
        return Http::get("{$this->baseUrl}/offers/{$reference}/prices");
    }

    public function postCreateOfferHub(array $payload): Response
    {
        return Http::post("{$this->baseUrl}/hub/create-offer", $payload);
    }
}
