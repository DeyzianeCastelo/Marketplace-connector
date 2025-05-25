<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\OfferImage as DomainOfferImage;
use App\Domain\Repositories\OfferImageRepositoryInterface;
use App\Infrastructure\Eloquent\Models\OfferImage as EloquentOfferImage;

class EloquentOfferImageRepository implements OfferImageRepositoryInterface
{
    public function save(DomainOfferImage $image): void
    {
        EloquentOfferImage::updateOrCreate(
            [
                'offer_id' => $image->offerReference,
                'url' => $image->url
            ]
        );
    }
}
