<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\OfferRepositoryInterface;
use App\Domain\Repositories\OfferImageRepositoryInterface;
use App\Domain\Repositories\OfferPriceRepositoryInterface;
use App\Infrastructure\Repositories\EloquentOfferRepository;
use App\Domain\Repositories\OfferProcessingRepositoryInterface;
use App\Infrastructure\Repositories\EloquentOfferImageRepository;
use App\Infrastructure\Repositories\EloquentOfferPriceRepository;
use App\Infrastructure\Repositories\RedisOfferProcessingRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OfferRepositoryInterface::class, EloquentOfferRepository::class);
        $this->app->bind(OfferImageRepositoryInterface::class, EloquentOfferImageRepository::class);
        $this->app->bind(OfferPriceRepositoryInterface::class, EloquentOfferPriceRepository::class);
        $this->app->bind(
            OfferProcessingRepositoryInterface::class,
            RedisOfferProcessingRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
