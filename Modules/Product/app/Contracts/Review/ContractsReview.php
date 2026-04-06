<?php

namespace Modules\Product\Contracts\Review;

use Illuminate\Support\Collection;

interface ContractsReview
{
    public function existsInProduct(int $productId): bool;

    public function getByProductId(int $productId): Collection;
}
