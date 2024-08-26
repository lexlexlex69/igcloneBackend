<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\userController;
use Illuminate\Http\Request;
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

//register and login api
Route::post('/user', [userController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    
    Route::get('/user', [userController::class, 'index']);
    Route::put('/user/{id}', [userController::class, 'update']);

    Route::get('/post', [PostController::class, 'index']);          //fetch all posts for timeline
    Route::get('/post/{id}', [PostController::class, 'show']);      //display specific post details
    Route::post('/post', [PostController::class, 'store']);         //creating new post
});
