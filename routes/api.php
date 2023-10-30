<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Modules\Invoices\Http\InvoiceController;

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

Route::get('/{id}', [InvoiceController::class, 'show']);
Route::post('/approve/{id}', [InvoiceController::class, 'approve']);
Route::post('/reject/{id}', [InvoiceController::class, 'reject']);
