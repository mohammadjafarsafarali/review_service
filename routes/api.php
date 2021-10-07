<?php

use App\Http\Controllers\Api\v1\OptionsController;
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

Route::get('/v1/review/{product_id}', [OptionsController::class, 'getOptions']);
Route::post('/v1/review-set/{product_id}', [OptionsController::class, 'setOptions']);
