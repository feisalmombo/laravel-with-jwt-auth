<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/refresh', [UserController::class, 'refresh']);
Route::get('/user', [UserController::class, 'getUser'])->middleware('auth.jwt');

Route::get('/todos', [TodoController::class, 'index']);
Route::post('/todo', [TodoController::class, 'store']);
Route::get('/todo/{id}', [TodoController::class, 'show']);
Route::put('/todo/{id}', [TodoController::class, 'update']);
Route::delete('/todo/{id}', [TodoController::class, 'destroy']);


Route::any('{any}', function(){
    return response()->json([
    	'status' => 'error',
        'message' => 'Resource not found'], 404);
})->where('any', '.*');


