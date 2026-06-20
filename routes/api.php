<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BookingController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/assets/package/{nama_paket}',
           [AssetController::class, 'getDetail']);

Route::post('/booking/create', [BookingController::class, 'store']);
