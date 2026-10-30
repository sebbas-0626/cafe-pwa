<?php

namespace App\Domains\Buyer\Repositories\Contracts;

use App\Domains\Buyer\Models\Buyer;
use Illuminate\Database\Eloquent\Collection;

interface BuyerRepositoryInterface
{
    /**
     * @return Collection<int, Buyer>
     */
    public function findActiveWithApprovedOffers(): Collection;

    public function findById(int $id): ?Buyer;

    /**
     * @param  array{name: string, type: string, description?: string|null, latitude: float|string, longitude: float|string, address?: string|null, phone?: string|null, is_active?: bool}  $data
     */
    public function create(array $data): Buyer;

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): ?Buyer;
}
