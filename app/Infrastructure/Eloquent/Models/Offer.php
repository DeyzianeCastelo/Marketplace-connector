<?php

namespace App\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'reference',
        'title',
        'description',
        'status',
        'stock',
        'import_state'
    ];

    public function images()
    {
        return $this->hasMany(OfferImage::class);
    }

    public function price()
    {
        return $this->hasOne(OfferPrice::class);
    }
}
