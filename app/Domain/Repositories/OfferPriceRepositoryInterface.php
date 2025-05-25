<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\OfferPrice;

interface OfferPriceRepositoryInterface
{
    public function save(OfferPrice $offerPrice): void;
}
