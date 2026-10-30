<?php

namespace App\Filament\Widgets;

use App\Domains\Buyer\Models\Buyer;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ActiveBuyersWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Compradores activos', Buyer::query()->where('is_active', true)->count()),
        ];
    }
}
