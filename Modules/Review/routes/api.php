<?php

use Illuminate\Support\Facades\Route;
use Modules\Review\Http\Controllers\ReviewController;

Route::prefix('v1')->group(function () {
    Route::apiResource('reviews', ReviewController::class)->names('api.review');
});
