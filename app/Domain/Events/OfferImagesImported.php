<?php

namespace App\Domain\Events;

class OfferImagesImported
{
    public function __construct(
        public string $reference,
        public array $images
    ) {
    }
}
