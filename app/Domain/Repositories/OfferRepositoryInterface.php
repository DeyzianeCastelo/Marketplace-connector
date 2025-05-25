<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Offer;

interface OfferRepositoryInterface
{
    public function save(Offer $offer): void;
    public function findByReference(string $reference): ?Offer;
}
