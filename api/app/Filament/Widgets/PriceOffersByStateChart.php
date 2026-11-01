<?php

namespace App\Filament\Widgets;

use App\Domains\PriceOffer\Models\PriceOffer;
use App\Enums\CoffeeState;
use App\Enums\UserRole;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class PriceOffersByStateChart extends ChartWidget
{
    protected ?string $heading = 'Ofertas vigentes por estado del café';

    protected ?string $description = 'Solo ofertas aprobadas y vigentes';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $user = Auth::user();

        $query = PriceOffer::query()->approvedAndValid();

        if ($user instanceof User && $user->role !== UserRole::Admin) {
            $query->where('buyer_id', $user->buyer_id);
        }

        $counts = $query
            ->selectRaw('coffee_state, COUNT(*) as aggregate')
            ->groupBy('coffee_state')
            ->pluck('aggregate', 'coffee_state');

        $labels = [];
        $data = [];

        foreach (CoffeeState::cases() as $state) {
            $labels[] = $state->label();
            $data[] = (int) ($counts[$state->value] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ofertas',
                    'data' => $data,
                    'backgroundColor' => ['#8f3b1c', '#006d44', '#734d25', '#ffb59c', '#9af5c0'],
                    'borderColor' => '#fff8f6',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
