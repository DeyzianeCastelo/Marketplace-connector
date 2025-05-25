<?php

namespace App\Domain\Entities;

class Offer
{
    public function __construct(
        public readonly string $reference,
        public readonly string $title,
        public readonly string $description,
        public readonly string $status,
        public readonly int $stock,
        public readonly array $images = [],
        public readonly ?float $price = null,
        public readonly ?int $id = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'stock' => $this->stock,
        ];
    }
}
