<?php

namespace App\Filament\Resources\PriceOffers\Schemas;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PriceOfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('buyer_id')
                    ->relationship('buyer', 'name', function (Builder $query) {
                        $user = Auth::user();

                        if ($user instanceof User && $user->role === UserRole::CooperativeAdmin) {
                            $query->where('id', $user->buyer_id);
                        }
                    })
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
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
