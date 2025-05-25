<?php

namespace App\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Application\Jobs\ImportOfferDetailsJob;

class ProcessOffersPageJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(protected int $page)
    {
    }

    public function handle()
    {
        Log::info("Processando página {$this->page} de anúncios.");

        $response = Http::get("http://host.docker.internal:3000/offers", [
            'page' => $this->page,
        ]);

        if ($response->failed()) {
            Log::error("Falha ao buscar página {$this->page} da API do Marketplace.");
            return;
        }

        $data = $response->json();

        $offers = $data['data']['offers'] ?? [];
        Log::info("Encontrados " . count($offers) . " anúncios na página {$this->page}.");

        foreach ($offers as $reference) {
            Log::info("Agendando processamento de detalhes do anúncio {$reference}.");
            dispatch(new ImportOfferDetailsJob($reference));
        }

        $pagination = $data['pagination'] ?? [];
        $currentPage = $this->page;
        $lastPage = $pagination['total_pages'] ?? $currentPage;

        if ($currentPage < $lastPage) {
            $nextPage = $pagination['next_page'] ?? ($currentPage + 1);
            Log::info("Agendando processamento da próxima página: {$nextPage}");
            dispatch(new self($nextPage));
        }
    }
}
