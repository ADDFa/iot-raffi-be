<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\LetterCategoryController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Auth;
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

Route::controller(AuthController::class)->group(function () {
    Route::post("/login", "login");
    Route::post("/refresh", "refreshToken");
    Route::post("/register", "register");
});

Route::middleware(Auth::class)->group(function () {
    Route::controller(ResultController::class)->group(function () {
        Route::get("/result", "index");
        Route::post("/result", "store");
    });

    Route::controller(MessageController::class)->group(function () {
        Route::get("/message", "index");
        Route::post("/message", "store");
    });
});
