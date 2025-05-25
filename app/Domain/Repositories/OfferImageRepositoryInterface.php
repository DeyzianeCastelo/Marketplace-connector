<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\OfferImage;

interface OfferImageRepositoryInterface
{
    public function save(OfferImage $offerImage): void;
}
