<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CobroController;
use App\Http\Controllers\UserController;

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

Route::post("login", [AuthController::class, 'login'])->name("login");

// Test middleware routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get("me", [AuthController::class, 'me'])->name("auth.current");
    Route::post("logout", [AuthController::class, 'logout'])->name("auth.logout");

    Route::resource('users', UserController::class)->except(['create', 'edit']);
    Route::resource('cobros', CobroController::class)->except(['create', 'edit']);
});
