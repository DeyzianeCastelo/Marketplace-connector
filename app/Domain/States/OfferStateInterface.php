<?php

namespace App\Domain\States;

interface OfferStateInterface
{
    public function handle(string $reference): void;
}
