<?php

namespace App\Domains\PriceOffer\Http\Controllers;

use App\Domains\PriceOffer\Repositories\Contracts\PriceOfferRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PriceOfferController extends Controller
{
    public function __construct(private readonly PriceOfferRepositoryInterface $priceOfferRepository) {}

    public function byVariety(int $id): JsonResponse
    {
        return response()->json($this->priceOfferRepository->findApprovedByVariety($id));
    }
}
