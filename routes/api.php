<?php

use App\Http\Controllers\Api\v1\CommentsController;
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
Route::prefix('v1/review')->group(function () {
    //get options for one product
    Route::get('get-options/{product_id}', [OptionsController::class, 'getOptions']);
    //set options for one product
    Route::post('set-options/{product_id}', [OptionsController::class, 'setOptions']);
    //insert new review(comment or vote or both)
    Route::post('review-insert', [CommentsController::class, 'insert']);
    //get list of all pending review
    Route::get('review-pending-list', [CommentsController::class, 'getAllPendingComments']);
    //change one review status
    Route::post('status-change', [CommentsController::class, 'changeReviewStatus']);
});

