<?php

namespace App\Providers;

use App\Repositories\Contracts\BuyerRepositoryInterface;
use App\Repositories\Contracts\CoffeeVarietyRepositoryInterface;
use App\Repositories\Contracts\PriceOfferRepositoryInterface;
use App\Repositories\Eloquent\BuyerRepository;
use App\Repositories\Eloquent\CoffeeVarietyRepository;
use App\Repositories\Eloquent\PriceOfferRepository;
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
