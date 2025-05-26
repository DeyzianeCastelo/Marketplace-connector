<?php

namespace App\Domain\Repositories;

interface OfferProcessingRepositoryInterface
{
    public function markPartAsCompleted(string $reference, string $partName): void;
    public function setPartExpiry(string $reference, int $expirationInSeconds): void;
    public function setPageProcessingCount(int $page, int $count): void;
    public function setLastPaginationPage(int $page): void;
    public function getLastPaginationPage(): ?int;
    public function getCompletedPartsCount(string $reference): int;
    public function clearCompletedParts(string $reference): void;
    public function decrementPageCounter(int $page): int;
}
