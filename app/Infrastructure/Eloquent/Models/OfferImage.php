<?php

namespace App\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class OfferImage extends Model
{
    protected $fillable = [
        'offer_id',
        'url'
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
