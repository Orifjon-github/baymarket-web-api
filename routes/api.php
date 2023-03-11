<?php

use App\Http\Controllers\AdvantageController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\SettingsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function () {

    Route::post('login', [HomepageController::class, 'login']);
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
        ]);
    });
});



Route::get('settings', [HomepageController::class, 'settings']);
Route::get('carousels', [HomepageController::class, 'carousels']);
Route::get('categories', [HomepageController::class, 'categories']);
Route::get('products', [HomepageController::class, 'products']);
Route::get('category/{id}', [HomepageController::class, 'showCategory']);
Route::get('specials', [HomepageController::class, 'specials']);
Route::get('additional-products', [HomepageController::class, 'additionalProducts']);
Route::get('popular-recipes', [HomepageController::class, 'popularRecipes']);
Route::get('testimonials', [HomepageController::class, 'testimonials']);
