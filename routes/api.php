<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProductController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(AuthController::class)->middleware(['auth:api'])->group(function () {
    Route::get('/me', 'me');
});

Route::post('/logout', [AuthController::class, 'logout']);

Route::controller(ProductController::class)->group(function () {
    Route::get('/home', 'home');
    Route::get('/products', 'index');
    Route::get('/products/{product}', 'show');
    Route::get('/categories/{slug}/products', 'byCategory');
});

Route::prefix('home')->controller(ProductController::class)->group(function () {
    Route::get('/suggested', 'suggested');
    Route::get('/popular', 'popular');
    Route::get('/recently-viewed', 'recentlyViewed');
});

Route::controller(BrandController::class)->group(function () {
    Route::get('/brands', 'index');
    Route::get('/brands/{slug}/products', 'products');
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/notes', [NoteController::class, 'index']);





