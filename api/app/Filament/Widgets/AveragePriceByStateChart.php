<?php

namespace App\Filament\Widgets;

use App\Domains\PriceOffer\Models\PriceOffer;
use App\Enums\CoffeeState;
use App\Enums\UserRole;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class AveragePriceByStateChart extends ChartWidget
{
    protected ?string $heading = 'Precio promedio por estado del café';

    protected ?string $description = 'Ofertas aprobadas y vigentes (COP/kg)';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $user = Auth::user();

        $query = PriceOffer::query()->approvedAndValid();

        if ($user instanceof User && $user->role !== UserRole::Admin) {
            $query->where('buyer_id', $user->buyer_id);
        }

        $averages = $query
            ->selectRaw('coffee_state, AVG(price_per_kg) as aggregate')
            ->groupBy('coffee_state')
            ->pluck('aggregate', 'coffee_state');

        $labels = [];
        $data = [];

        foreach (CoffeeState::cases() as $state) {
            $labels[] = $state->label();
            $data[] = round((float) ($averages[$state->value] ?? 0), 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Precio promedio (COP/kg)',
                    'data' => $data,
                    'backgroundColor' => ['#8f3b1c', '#006d44', '#734d25', '#ffb59c', '#9af5c0'],
                    'borderColor' => '#8f3b1c',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
