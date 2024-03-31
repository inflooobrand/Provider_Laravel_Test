<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PaymentController;


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

Route::post('register',[ApiController::class,'register']);
Route::post('login',[ApiController::class,'loginUser']);



Route::group(["middleware"=>["auth:sanctum"]], function(){
    Route::get('dashboard',[ApiController::class, 'dashboard']);
    Route::get('logout',[ApiController::class,'logout']);
    Route::apiResources(['products' => ProductController::class]);
    Route::apiResources(['orders' => OrderController::class]);
});


