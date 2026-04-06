<?php

use Illuminate\Support\Facades\Route;
use Modules\Review\Http\Controllers\ReviewController;

Route::get('reviews', [ReviewController::class, 'index'])->name('review.index');
Route::get('products/{product}/reviews/create', [ReviewController::class, 'create'])->name('review.create');
Route::post('products/{product}/reviews', [ReviewController::class, 'store'])->name('review.store');
