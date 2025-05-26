<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Support\Facades\Redis;
use App\Domain\Repositories\OfferProcessingRepositoryInterface;

class RedisOfferProcessingRepository implements OfferProcessingRepositoryInterface
{
    public function markPartAsCompleted(string $reference, string $partName): void
    {
        Redis::sadd("offers:{$reference}:completed_parts", $partName);
    }

    public function setPartExpiry(string $reference, int $expirationInSeconds): void
    {
        Redis::expire("offers:{$reference}:completed_parts", $expirationInSeconds);
    }

    public function setPageProcessingCount(int $page, int $count): void
    {
        Redis::set("offers:processing:page:{$page}", $count);
    }

    public function setLastPaginationPage(int $page): void
    {
        Redis::set("offers:pagination:last_page", $page);
    }

    public function getLastPaginationPage(): ?int
    {
        return Redis::get("offers:pagination:last_page");
    }

    public function getCompletedPartsCount(string $reference): int
    {
        return Redis::scard("offers:{$reference}:completed_parts");
    }

    public function clearCompletedParts(string $reference): void
    {
        Redis::del("offers:{$reference}:completed_parts");
    }

    public function decrementPageCounter(int $page): int
    {
        return Redis::decr("offers:processing:page:{$page}");
    }
}
