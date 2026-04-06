<?php

use Illuminate\Support\Facades\Route;
use Modules\Review\Http\Controllers\ReviewController;

Route::prefix('v1')->group(function () {
    Route::get('reviews', [ReviewController::class, 'index'])->name('api.review.index');
    Route::post('products/{product}/reviews', [ReviewController::class, 'create'])->name('api.review.create');
});
