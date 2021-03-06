<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiCepatController;
use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/get-origin', [SiCepatController::class, 'get_tarif']);
    Route::get('/waybill', [SiCepatController::class, 'waybill']);
    Route::get('/waybill-refno', [SiCepatController::class, 'waybill_refno']);
    Route::post('/pickup', [SiCepatController::class, 'pickup']);
    Route::post('/cancel-pickup', [SiCepatController::class, 'cancel_pickup']);
});

