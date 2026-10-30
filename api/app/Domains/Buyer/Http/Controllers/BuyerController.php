<?php

namespace App\Domains\Buyer\Http\Controllers;

use App\Domains\Buyer\Repositories\Contracts\BuyerRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BuyerController extends Controller
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository) {}

    public function index(): JsonResponse
    {
        return response()->json($this->buyerRepository->findActiveWithApprovedOffers());
    }
}
