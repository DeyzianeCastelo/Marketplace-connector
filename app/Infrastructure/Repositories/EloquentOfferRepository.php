<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Support\Facades\Log;
use App\Domain\Entities\Offer as DomainOffer;
use App\Infrastructure\Eloquent\Models\Offer as EloquentOffer;
use App\Domain\Repositories\OfferRepositoryInterface;

class EloquentOfferRepository implements OfferRepositoryInterface
{
    public function save(DomainOffer $offer): void
    {
        Log::info('Salvando oferta no repositório', $offer->toArray());

        EloquentOffer::updateOrCreate(
            ['reference' => $offer->reference],
            [
                'title' => $offer->title,
                'description' => $offer->description,
                'status' => $offer->status,
                'stock' => $offer->stock,
            ]
        );
    }

    public function findByReference(string $reference): ?DomainOffer
    {
        $record = EloquentOffer::firstWhere('reference', $reference);

        return $record ? $this->mapToDomain($record) : null;
    }

    private function mapToDomain(EloquentOffer $record): DomainOffer
    {
        return new DomainOffer(
            id: $record->id,
            reference: $record->reference,
            title: $record->title,
            description: $record->description,
            status: $record->status,
            stock: $record->stock,
        );
    }
}
