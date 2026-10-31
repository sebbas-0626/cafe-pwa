<?php

namespace App\Filament\Widgets;

use App\Domains\Buyer\Models\Buyer;
use App\Domains\PriceOffer\Models\PriceOffer;
use App\Enums\UserRole;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $isCooperativeAdmin = $user instanceof User && $user->role !== UserRole::Admin;

        $buyersQuery = Buyer::query()->where('is_active', true);

        $approvedQuery = PriceOffer::query()->approvedAndValid();

        $pendingQuery = PriceOffer::query()->where('status', 'pending');

        if ($isCooperativeAdmin) {
            $buyersQuery->where('id', $user->buyer_id);
            $approvedQuery->where('buyer_id', $user->buyer_id);
            $pendingQuery->where('buyer_id', $user->buyer_id);
        }

        return [
            Stat::make('Compradores activos', $buyersQuery->count())
                ->description($isCooperativeAdmin ? 'Solo su cooperativa' : 'Todas las cooperativas')
                ->descriptionIcon(Heroicon::OutlinedBuildingStorefront)
                ->color('success')
                ->icon(Heroicon::OutlinedBuildingStorefront),
            Stat::make('Ofertas aprobadas vigentes', $approvedQuery->count())
                ->description($isCooperativeAdmin ? 'Ofertas de su cooperativa' : 'De todos los compradores')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->color('primary')
                ->icon(Heroicon::OutlinedCurrencyDollar),
            Stat::make('Ofertas pendientes', $pendingQuery->count())
                ->description($isCooperativeAdmin ? 'De su cooperativa' : 'Requieren revisión')
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->color('warning')
                ->icon(Heroicon::OutlinedClipboardDocumentList),
            Stat::make('Caficultores registrados', $isCooperativeAdmin ? '—' : User::query()->where('role', UserRole::Farmer)->count())
                ->description($isCooperativeAdmin ? 'No aplica a su cooperativa' : 'Usuarios con rol farmer')
                ->descriptionIcon(Heroicon::OutlinedUsers)
                ->color('info')
                ->icon(Heroicon::OutlinedUserGroup),
        ];
    }
}
