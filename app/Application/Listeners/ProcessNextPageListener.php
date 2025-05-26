<?php

namespace App\Application\Listeners;

use Illuminate\Support\Facades\Log;
use App\Application\Jobs\ProcessOffersPageJob;
use App\Domain\Events\OffersPageProcessingCompleted;
use App\Domain\Repositories\OfferProcessingRepositoryInterface;

class ProcessNextPageListener
{
    public function __construct(private OfferProcessingRepositoryInterface $processingRepository)
    {
    }

    public function handle(OffersPageProcessingCompleted $event)
    {
        $nextPage = $event->page + 1;
        $lastPage = $this->processingRepository->getLastPaginationPage();

        if ($nextPage <= $lastPage) {
            Log::info("Todos os detalhes da página {$event->page} foram processados. Agendando página {$nextPage}.");
            dispatch(new ProcessOffersPageJob($nextPage));
        }
    }
}
