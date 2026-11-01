<?php

namespace App\Domains\Buyer\Http\Controllers;

use App\Domains\Buyer\Repositories\Contracts\BuyerRepositoryInterface;
use App\Enums\CoffeeState;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuyerController extends Controller
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository) {}

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'coffee_state' => ['sometimes', Rule::enum(CoffeeState::class)],
        ]);

        $coffeeState = isset($validated['coffee_state'])
            ? CoffeeState::from($validated['coffee_state'])
            : CoffeeState::PergaminoSeco;

        return response()->json($this->buyerRepository->findActiveWithApprovedOffers($coffeeState));
    }
}
