<?php

namespace App\Domain\Entities;

class OfferImage
{
    public function __construct(
        public readonly string $url,
        public readonly string $offerReference,
    ) {
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'offer_reference' => $this->offerReference,
        ];
    }
}
