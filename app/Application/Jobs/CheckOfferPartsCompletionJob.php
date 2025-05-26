<?php

namespace App\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Domain\Events\OffersPageProcessingCompleted;
use App\Domain\Repositories\OfferProcessingRepositoryInterface;

class CheckOfferPartsCompletionJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    private const TOTAL_PARTS = 3;

    public function __construct(private string $reference, private int $page)
    {
    }

    public function handle(OfferProcessingRepositoryInterface $repository)
    {
        $completed = $repository->getCompletedPartsCount($this->reference);

        if ($completed >= self::TOTAL_PARTS) {
            $repository->clearCompletedParts($this->reference);
            $remaining = $repository->decrementPageCounter($this->page);

            if ($remaining === 0) {
                event(new OffersPageProcessingCompleted($this->page));
            }
        }
    }
}
