<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1;

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

Route::middleware('unpaid.merchant')->group(function () {

    Route::middleware('throttle:api')->prefix('v1/{token}')->name('api.v1.')->group(function () {
        Route::post('{event}/{id}/{value}', [V1\LogApiController::class, 'transaction'])->name('transaction');
        Route::get('history/{id}', [V1\LogApiController::class, 'getMemberHistoryPoint'])->name('getMemberHistoryPoint');
        Route::resource('members', V1\MemberController::class);
    });

});

