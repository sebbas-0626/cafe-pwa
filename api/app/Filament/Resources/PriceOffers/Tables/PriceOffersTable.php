<?php

namespace App\Filament\Resources\PriceOffers\Tables;

use App\Enums\CoffeeState;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PriceOffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('buyer.name')
                    ->searchable(),
                TextColumn::make('coffeeVariety.name')
                    ->searchable(),
                TextColumn::make('coffee_state')
                    ->label('Estado del café')
                    ->formatStateUsing(fn (CoffeeState|string|null $state): string => $state instanceof CoffeeState
                        ? $state->label()
                        : (CoffeeState::tryFrom((string) $state)?->label() ?? '-'))
                    ->sortable(),
                TextColumn::make('price_per_kg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('moisture_required')
                    ->label('Humedad exigida')
                    ->numeric()
                    ->toggleable(),
                TextColumn::make('yield_factor')
                    ->label('Factor de rendimiento')
                    ->numeric()
                    ->toggleable(),
                TextColumn::make('unit')
                    ->searchable(),
                TextColumn::make('valid_from')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('valid_until')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('coffee_state')
                    ->label('Estado del café')
                    ->options(CoffeeState::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
