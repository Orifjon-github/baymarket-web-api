<?php

use App\Http\Controllers\AdvantageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\SettingsController;
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

Route::post('orders', [OrderController::class, 'store']);
Route::post('partnerships', [PartnershipController::class, 'store']);
Route::get('settings', [HomepageController::class, 'settings'])->name('settings');
Route::get('test', [HomepageController::class, 'test']);
Route::get('carousels', [HomepageController::class, 'carousels']);
Route::get('categories', [HomepageController::class, 'categories']);
Route::get('products', [HomepageController::class, 'products']);
Route::get('category/{id}', [HomepageController::class, 'showCategory']);
Route::get('specials', [HomepageController::class, 'specials']);
Route::get('additional-products', [HomepageController::class, 'additionalProducts']);
Route::get('popular-recipes', [HomepageController::class, 'popularRecipes']);
Route::get('testimonials', [HomepageController::class, 'testimonials']);


Route::middleware(['cors'])->group(function () {
    Route::post('login', [AuthController::class, 'login']);;
});


Route::middleware(['auth:sanctum', 'cors'])->prefix('admin')->group(function () {

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::put('orders/{id}', [OrderController::class, 'update']);
    Route::delete('orders/{id}', [OrderController::class, 'destroy']);
    Route::get('partnerships', [PartnershipController::class, 'index']);
    Route::get('partnerships/{id}', [PartnershipController::class, 'show']);

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index']);
        Route::put('/update', [SettingsController::class, 'update']);
        Route::resource('logos', LogoController::class)->only([
            'index', 'destroy', 'show', 'update'
        ]);
        Route::resource('advantages', AdvantageController::class)->only([
            'index', 'update', 'store', 'destroy', 'show'
        ]);
        Route::resource('socials', SocialController::class)->only([
            'index', 'update', 'store', 'destroy', 'show'
        ])->middleware(['cors']);
    });
});

