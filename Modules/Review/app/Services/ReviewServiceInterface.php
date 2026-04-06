<?php

namespace Modules\Review\Services;

use Illuminate\Support\Collection;

interface ReviewServiceInterface
{
    public function getAllReviews(): Collection;

    public function getReviewsByProductId(int $productId): Collection;

    public function hasReviewsForProductId(int $productId): bool;

    public function createReview(array $attributes): \Modules\Review\Models\Review;
}
