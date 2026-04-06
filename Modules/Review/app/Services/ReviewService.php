<?php

namespace Modules\Review\Services;

use Illuminate\Support\Collection;
use Modules\Review\Repositories\ReviewRepositoryInterface;

class ReviewService implements ReviewServiceInterface
{
    public function __construct(
        private readonly ReviewRepositoryInterface $reviews,
    ) {}

    public function getAllReviews(): Collection
    {
        return $this->reviews->all();
    }

    public function getReviewsByProductId(int $productId): Collection
    {
        return $this->reviews->getByProductId($productId);
    }

    public function hasReviewsForProductId(int $productId): bool
    {
        return $this->reviews->existsByProductId($productId);
    }

    public function createReview(array $attributes): \Modules\Review\Models\Review
    {
        return $this->reviews->create($attributes);
    }
}
