<?php

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

Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::get('/ticket', [\App\Http\Controllers\TicketController::class, 'list']);
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/ticket/create', [\App\Http\Controllers\TicketController::class, 'create']);
    Route::put('/ticket/update/{id}', [\App\Http\Controllers\TicketController::class, 'update']);
    Route::put('/ticket/resolve/{id}', [\App\Http\Controllers\TicketController::class, 'resolve']);
    Route::delete('/ticket/delete/{id}', [\App\Http\Controllers\TicketController::class, 'delete']);
});
