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


// Route::controller(TodoController::class)->group(function () {
//     Route::get('/todos', 'index');
//     Route::post('/todo', 'store');
//     Route::get('/todo/{id}', 'show');
//     Route::put('/todo/{id}', 'update');
//     Route::delete('/todo/{id}', 'destroy');
// });
Route::get('/todos', [TodoController::class, 'index']);


Route::any('{any}', function(){
    return response()->json([
    	'status' => 'error',
        'message' => 'Resource not found'], 404);
})->where('any', '.*');


