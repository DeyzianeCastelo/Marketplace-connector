<?php

namespace App\Domain\Events;

class OfferPricesImported
{
    public function __construct(
        public string $reference,
        public array $prices
    ) {
    }
}
