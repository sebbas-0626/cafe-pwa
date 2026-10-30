<?php

namespace App\Providers;

use App\Domains\Buyer\Repositories\Contracts\BuyerRepositoryInterface;
use App\Domains\Buyer\Repositories\Eloquent\BuyerRepository;
use App\Domains\CoffeeVariety\Repositories\Contracts\CoffeeVarietyRepositoryInterface;
use App\Domains\CoffeeVariety\Repositories\Eloquent\CoffeeVarietyRepository;
use App\Domains\PriceOffer\Repositories\Contracts\PriceOfferRepositoryInterface;
use App\Domains\PriceOffer\Repositories\Eloquent\PriceOfferRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        BuyerRepositoryInterface::class => BuyerRepository::class,
        PriceOfferRepositoryInterface::class => PriceOfferRepository::class,
        CoffeeVarietyRepositoryInterface::class => CoffeeVarietyRepository::class,
    ];
}
