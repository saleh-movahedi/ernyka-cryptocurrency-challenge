<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatioController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::name('currency.')->group(function () {
    Route::get('/currency', [CurrencyController::class, 'index'])->name('index');
    Route::get('/currency/{id}', [CurrencyController::class, 'show'])->name('show');
    Route::post('/currency', [CurrencyController::class, 'store'])->name('store');
    Route::put('/currency/{id}', [CurrencyController::class, 'update'])->name('update');
    Route::delete('/currency/{id}', [CurrencyController::class, 'destroy'])->name('delete');

});

Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');

Route::post('/order', [OrderController::class, 'store'])->name('order.store');
//Route::post('/order/buy', [OrderController::class, 'buy'])->name('order.buy');

Route::get('/remote-fetch', [CurrencyController::class, 'remoteFetch'])->name('remote_fetch');

Route::get('/ratio', [RatioController::class, 'index'])->name('ratio.index');
