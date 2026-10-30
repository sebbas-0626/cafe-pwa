<?php

namespace App\Filament\Resources\PriceOffers\Pages;

use App\Filament\Resources\PriceOffers\PriceOfferResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPriceOffer extends EditRecord
{
    protected static string $resource = PriceOfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
