<?php

namespace App\Filament\Resources\CoffeeVarieties;

use App\Domains\CoffeeVariety\Models\CoffeeVariety;
use App\Filament\Resources\CoffeeVarieties\Pages\CreateCoffeeVariety;
use App\Filament\Resources\CoffeeVarieties\Pages\EditCoffeeVariety;
use App\Filament\Resources\CoffeeVarieties\Pages\ListCoffeeVarieties;
use App\Filament\Resources\CoffeeVarieties\Schemas\CoffeeVarietyForm;
use App\Filament\Resources\CoffeeVarieties\Tables\CoffeeVarietiesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CoffeeVarietyResource extends Resource
{
    protected static ?string $model = CoffeeVariety::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CoffeeVarietyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoffeeVarietiesTable::configure($table);
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
            'index' => ListCoffeeVarieties::route('/'),
            'create' => CreateCoffeeVariety::route('/create'),
            'edit' => EditCoffeeVariety::route('/{record}/edit'),
        ];
    }
}
