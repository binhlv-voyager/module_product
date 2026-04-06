<?php

use Illuminate\Support\Facades\Route;
use Modules\Review\Http\Controllers\ReviewController;

Route::get('reviews', [ReviewController::class, 'index'])->name('review.index');
Route::post('products/{product}/reviews', [ReviewController::class, 'create'])->name('review.create');
