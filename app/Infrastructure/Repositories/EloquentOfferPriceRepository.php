<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\OfferPrice as DomainOfferPrice;
use App\Domain\Repositories\OfferPriceRepositoryInterface;
use App\Infrastructure\Eloquent\Models\OfferPrice as EloquentOfferPrice;

class EloquentOfferPriceRepository implements OfferPriceRepositoryInterface
{
    public function save(DomainOfferPrice $price): void
    {
        EloquentOfferPrice::updateOrCreate(
            ['offer_id' => $price->offerReference],
            ['price' => $price->price]
        );
    }
}
