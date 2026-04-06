<?php

namespace Modules\Review\Adapters\Product;

use Illuminate\Support\Collection;
use Modules\Product\Contracts\Review\ContractsReview;
use Modules\Review\Repositories\ReviewRepositoryInterface;

class ProductReviewAdapter implements ContractsReview
{
    public function __construct(
        private readonly ReviewRepositoryInterface $reviews,
    ) {}

    public function existsInProduct(int $productId): bool
    {
        return $this->reviews->existsByProductId($productId);
    }

    public function getByProductId(int $productId): Collection
    {
        return $this->reviews->getByProductId($productId);
    }
}
