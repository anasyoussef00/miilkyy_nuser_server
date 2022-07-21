<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\Authentication;
use App\Http\Controllers\NuseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| showNuserNuseListis assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', [Authentication::class, 'register']);
    Route::post('login', [Authentication::class, 'login']);
    // Route::get('nuser/password/{psswd}', [Authentication::class, 'checkIfUserPasswordMatches']);
});

Route::get('profile/{id}', [NuseController::class, 'showNuserNuseList']);
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('logout', [Authentication::class, 'logout']);
    });
    Route::post('like/{id}', [NuseController::class, 'like']);
    Route::post('unlike/{id}', [NuseController::class, 'unlike']);
    Route::prefix('nuse')->group(function () {
        Route::get('all', [NuseController::class, 'show']);
        Route::post('create', [NuseController::class, 'store']);
        Route::delete('delete/{id}', [NuseController::class, 'destroy']);
        Route::get('{id}', [NuseController::class, 'showSpecificNuse']);
        Route::get('test/{id}', [NuseController::class, 'testLike']);
    });
});
