<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\ProductController;
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
Route::get('feed/export/{type?}', [FeedController::class, 'export']);
