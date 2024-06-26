<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ItemController;
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

// public routes 
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


// private routes
Route::middleware(['auth:sanctum'])->group(function() {

    //Auth Routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // ================== Inventory Routes ===================
    Route::prefix('inventory')->group(function () {
        Route::get("/all", [InventoryController::class, 'all']);
        Route::post("/create", [InventoryController::class, 'create']);
        Route::put("/update", [InventoryController::class, 'update']);
        Route::delete("/delete/id={id}", [InventoryController::class, 'delete']);
     
    }); 

    // ================== Item Routes ===================
    Route::prefix('item')->group(function () {
        Route::get("/inventoryid={inventoryId}/all", [ItemController::class, 'all']);
        Route::post("/create", [ItemController::class, 'create']);
        Route::post("/update", [ItemController::class, 'update']);
        Route::delete("/delete/id={id}", [ItemController::class, 'delete']);
    }); 
    
    
});

Route::fallback(function(){
    return response()->json([
        'message' => 'API link is not valid or the Method is not supported for this route.'
    ], 400);
});