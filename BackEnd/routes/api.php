<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MasterMaterialController;
use App\Http\Controllers\Api\MasterMemberController;
use App\Http\Controllers\Api\TransSOController;
use App\Http\Controllers\Api\TResepController;
use App\Http\Controllers\TSODController;
use App\Http\Controllers\TSOHController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('api.token');
Route::get('auth/verify', [AuthController::class, 'verify'])->middleware('api.token');

Route::middleware('api.token')->prefix('/v1')->group(function () {
    Route::resource('users', UserController::class)->except('create', 'edit');
    Route::resource('materials', MasterMaterialController::class)->except(['create', 'edit']);
    Route::resource('members', MasterMemberController::class)->except(['create', 'edit']);
    Route::resource('treceipts', TResepController::class)->except(['create', 'edit']);
    Route::resource('transso', TransSOController::class)->except(['create', 'edit']);

    // Route::resource('materials', MaterialController::class)->except('create', 'edit');
    // Route::resource('customers', CustomerController::class)->except('create', 'edit');
    // Route::resource('customer-receipts', CustomerReceiptController::class)->except('create', 'edit');
    // Route::resource('sales-order', SalesOrderController::class)->except('create', 'edit');

});

Route::fallback(function () {
    $statusCode = 404;
    $message = "Request API not found!";
    return response()->json(GeneratePayload([$statusCode, $message]))->setStatusCode($statusCode);
});
