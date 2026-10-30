<?php

namespace App\Filament\Resources\PriceOffers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PriceOfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('buyer_id')
                    ->relationship('buyer', 'name')
                    ->required(),
                Select::make('coffee_variety_id')
                    ->relationship('coffeeVariety', 'name')
                    ->required(),
                TextInput::make('price_per_kg')
                    ->required()
                    ->numeric(),
                TextInput::make('unit')
                    ->required()
                    ->default('kg'),
                DateTimePicker::make('valid_from')
                    ->required(),
                DateTimePicker::make('valid_until')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
