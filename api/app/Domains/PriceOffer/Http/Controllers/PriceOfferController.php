<?php

namespace App\Domains\PriceOffer\Http\Controllers;

use App\Domains\PriceOffer\Repositories\Contracts\PriceOfferRepositoryInterface;
use App\Enums\CoffeeState;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PriceOfferController extends Controller
{
    public function __construct(private readonly PriceOfferRepositoryInterface $priceOfferRepository) {}

    public function byVariety(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'coffee_state' => ['sometimes', Rule::enum(CoffeeState::class)],
        ]);

        $coffeeState = isset($validated['coffee_state'])
            ? CoffeeState::from($validated['coffee_state'])
            : CoffeeState::PergaminoSeco;

        return response()->json($this->priceOfferRepository->findApprovedByVariety($id, $coffeeState));
    }
}
