<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFeedController;
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

Route::prefix('auth')->group(__DIR__ . '/auth.php');
Route::apiResource('product', ProductController::class);
Route::get('feed/export/{merchant}/{fileFormat}', [ProductFeedController::class, 'export'])->name('feeds.export');
