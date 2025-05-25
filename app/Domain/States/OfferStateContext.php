<?php

namespace App\Domain\States;

class OfferStateContext
{
    public function __construct(
        private OfferStateInterface $state
    ) {
    }

    public function setState(OfferStateInterface $state)
    {
        $this->state = $state;
    }

    public function handle(string $reference)
    {
        $this->state->handle($reference);
    }
}
