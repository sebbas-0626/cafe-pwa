<?php

namespace App\Filament\Resources\PriceOffers\Pages;

use App\Filament\Resources\PriceOffers\PriceOfferResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPriceOffers extends ListRecords
{
    protected static string $resource = PriceOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
