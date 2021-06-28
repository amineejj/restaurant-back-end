<?php

use App\Http\Controllers\PlatController;
use App\Http\Controllers\AuthController;
use App\Models\Plat;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:clients'])->group(function () {
    Route::get('plat/add/{id}', [PlatController::class, 'addToCart']);
});

Route::middleware(['auth:admins'])->group(function () {
    Route::resource('plat', PlatController::class);
});

Route::middleware(['auth:users'])->group(function () {
    Route::get('plat', [PlatController::class, 'index']);
    Route::get('plat/search/{nom}', [PlatController::class, 'search']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
