<?php

use App\Domains\Buyer\Http\Controllers\BuyerController;
use App\Domains\PriceOffer\Http\Controllers\PriceOfferController;
use Illuminate\Support\Facades\Route;

Route::get('/buyers', [BuyerController::class, 'index']);
Route::get('/price-offers/variety/{id}', [PriceOfferController::class, 'byVariety']);
