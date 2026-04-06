<?php

namespace Modules\Product\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Product\Models\Product;

interface ProductServiceInterface
{
    public function getAllProducts(): Collection;

    public function paginateProducts(int $perPage = 10): LengthAwarePaginator;

    public function getProductById(int $id): Product;

    public function getReviewsByProductId(int $productId): Collection;

    public function getCategoryOptions(): Collection;

    public function createProduct(array $attributes): Product;

    public function updateProduct(int $id, array $attributes): bool;

    public function deleteProduct(int $id): ?bool;
}
