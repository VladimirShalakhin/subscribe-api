<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RubricController;
use App\Http\Controllers\API\SubscribeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::controller(SubscribeController::class)->group(function () {
    Route::post('subscriber/subscribe', [SubscribeController::class, 'subscribe']);
    Route::post('subscriber/unsubscribe', [SubscribeController::class, 'unsubscribe']);
    Route::post('subscriber/confirmsubscription/{token}/{email}/{rubric}', [SubscribeController::class, 'confirmSubscription']);
    Route::post('subscriber/confirmunsubscription/{token}/{email}/{rubric}', [SubscribeController::class, 'confirmUnsubscription']);
    Route::post('subscriber/unsubscribeall', [SubscribeController::class, 'unsubscribeAll']);
    Route::post('subscriber/confirmunsubsctiptionall/{token}/{email}/{rubric}', [SubscribeController::class, 'confirmUnsubscribeAll']);
});

Route::get('rubric/{rubric_id}/email', [RubricController::class, 'get']);
Route::post('/email/{email_id}/verify/{token}', [\App\Http\Controllers\API\EmailController::class, 'verify']);

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout');
    Route::post('refresh', 'refresh')->name('refresh');
    Route::get('user-profile', 'profile')->name('user-profile');
});
