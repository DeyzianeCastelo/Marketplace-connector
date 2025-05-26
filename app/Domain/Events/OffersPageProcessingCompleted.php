<?php

namespace App\Domain\Events;

class OffersPageProcessingCompleted
{
    public function __construct(public int $page)
    {
    }
}
