<?php

namespace App\Domain\Entities;

class OfferPrice
{
    public function __construct(
        public readonly float $price,
        public readonly string $offerReference,
    ) {
    }

    public function toArray(): array
    {
        return [
            'price' => $this->price,
            'offer_reference' => $this->offerReference,
        ];
    }
}
