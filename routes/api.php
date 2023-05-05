<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;

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

Route::middleware([JwtMiddleware::class])->group(function () {

    Route::resource('checklist', ChecklistController::class);
    Route::get('checklist/{id}/item', [ChecklistItemController::class, 'index']);
    Route::post('checklist/{id}/item', [ChecklistItemController::class, 'create']);
    Route::get('checklist/{id}/item/{itemId}', [ChecklistItemController::class, 'getByChecklistId']);
    Route::delete('checklist/{id}/item/{itemId}', [ChecklistItemController::class, 'destroy']);
    Route::put('checklist/{id}/item/{itemId}', [ChecklistItemController::class, 'update']);
    Route::put('checklist/{id}/item/rename/{itemId}', [ChecklistItemController::class, 'renameItem']);

});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);