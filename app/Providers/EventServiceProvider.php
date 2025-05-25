<?php

namespace App\Providers;

use App\Domain\Events\OfferImported;
use App\Domain\Events\OfferImagesImported;
use App\Domain\Events\OfferPricesImported;
use App\Application\Listeners\SendOfferToHubListener;
use App\Application\Listeners\ImportOfferImagesListener;
use App\Application\Listeners\ImportOfferPricesListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * O array de eventos para o qual os listeners devem ser registrados.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        OfferImported::class => [
            ImportOfferImagesListener::class,
        ],
        OfferImagesImported::class => [
            ImportOfferPricesListener::class,
        ],
        OfferPricesImported::class => [
            SendOfferToHubListener::class,
        ],
    ];

    /**
     * Registre quaisquer eventos para sua aplicação.
     */
    public function boot(): void
    {
        //
    }
}
