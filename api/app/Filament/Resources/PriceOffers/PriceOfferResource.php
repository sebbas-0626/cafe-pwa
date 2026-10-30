<?php

namespace App\Filament\Resources\PriceOffers;

use App\Domains\PriceOffer\Models\PriceOffer;
use App\Filament\Resources\PriceOffers\Pages\CreatePriceOffer;
use App\Filament\Resources\PriceOffers\Pages\EditPriceOffer;
use App\Filament\Resources\PriceOffers\Pages\ListPriceOffers;
use App\Filament\Resources\PriceOffers\Schemas\PriceOfferForm;
use App\Filament\Resources\PriceOffers\Tables\PriceOffersTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PriceOfferResource extends Resource
{
    protected static ?string $model = PriceOffer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PriceOfferForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PriceOffersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPriceOffers::route('/'),
            'create' => CreatePriceOffer::route('/create'),
            'edit' => EditPriceOffer::route('/{record}/edit'),
        ];
    }
}
