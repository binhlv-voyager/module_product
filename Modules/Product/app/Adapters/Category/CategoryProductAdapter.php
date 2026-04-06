<?php

namespace Modules\Product\Adapters\Category;

use Modules\Category\Contracts\Product\ContractsProduct;
use Modules\Product\Repositories\ProductRepositoryInterface;

class CategoryProductAdapter implements ContractsProduct
{
    public function __construct(
        private readonly ProductRepositoryInterface $products,
    ) {}

    public function existsInCategory(int $categoryId): bool
    {
        return $this->products->existsByCategoryId($categoryId);
    }
}
