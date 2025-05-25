<?php

namespace App\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class OfferPrice extends Model
{
    protected $fillable = [
        'offer_id',
        'price',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
