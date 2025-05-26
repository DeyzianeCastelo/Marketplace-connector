<?php

namespace App\Domain\Events;

class OfferImported
{
    public function __construct(
        public string $reference,
        public array $data
    ) {
    }
}
