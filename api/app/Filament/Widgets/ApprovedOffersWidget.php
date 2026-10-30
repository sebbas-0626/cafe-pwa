<?php

namespace App\Filament\Widgets;

use App\Domains\PriceOffer\Models\PriceOffer;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApprovedOffersWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Ofertas aprobadas vigentes', PriceOffer::query()->approvedAndValid()->count()),
        ];
    }
}
