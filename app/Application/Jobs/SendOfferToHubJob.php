<?php

namespace App\Application\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Infrastructure\Services\OfferApiService;
use App\Domain\Repositories\OfferRepositoryInterface;

class SendOfferToHubJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private string $reference
    ) {
    }

    public function handle(OfferApiService $api, OfferRepositoryInterface $offerRepository): void
    {
        $offer = $offerRepository->findByReference($this->reference);

        if (!$offer) {
            Log::error("Anúncio {$this->reference} não encontrado para envio ao Hub.");
            return;
        }

        $payload = [
            'title' => $offer->title,
            'description' => $offer->description,
            'status' => $offer->status,
            'stock' => $offer->stock,
        ];

        $response = $api->postCreateOfferHub($payload);

        if ($response->successful()) {
            Log::info("Anúncio {$this->reference} enviado com sucesso ao Hub.");
        } else {
            Log::error("Erro ao enviar o anúncio {$this->reference} ao Hub: {$response->body()}");
        }
    }
}
