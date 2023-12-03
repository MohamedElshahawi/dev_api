<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

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


Route::Post('register' , [AuthController::class , 'register']);
Route::Post('login' , [AuthController::class , 'login']);

Route::group(['middleware' => ['auth:api']] ,function (){
    Route::get('logout' , [AuthController::class , 'logout']);
    // Route::apiResource('users', UserController::class);
    // Route::apiResource('tasks', TaskController::class);


});
