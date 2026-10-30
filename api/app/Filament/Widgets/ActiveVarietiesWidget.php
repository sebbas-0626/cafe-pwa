<?php

namespace App\Filament\Widgets;

use App\Domains\CoffeeVariety\Models\CoffeeVariety;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ActiveVarietiesWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Variedades activas', CoffeeVariety::query()->where('is_active', true)->count()),
        ];
    }
}
