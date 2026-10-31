<?php

namespace App\Filament\Resources\PriceOffers\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\PriceOffers\PriceOfferResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePriceOffer extends CreateRecord
{
    protected static string $resource = PriceOfferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'approved';

        $user = Auth::user();

        if ($user instanceof User && $user->role === UserRole::CooperativeAdmin) {
            $data['buyer_id'] = $user->buyer_id;
        }

        return $data;
    }
}
