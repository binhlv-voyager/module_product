<?php

namespace Modules\Product\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $products,
    ) {}

    public function getAllProducts(): Collection
    {
        return $this->products->all();
    }

    public function paginateProducts(int $perPage = 10): LengthAwarePaginator
    {
        return $this->products->paginate($perPage);
    }

    public function getProductById(int $id): Product
    {
        return $this->products->findOrFail($id);
    }

    public function getCategoryOptions(): Collection
    {
        return Category::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();
    }

    public function createProduct(array $attributes): Product
    {
        return $this->products->create($attributes);
    }

    public function updateProduct(int $id, array $attributes): bool
    {
        $product = $this->products->findOrFail($id);

        return $this->products->update($product, $attributes);
    }

    public function deleteProduct(int $id): ?bool
    {
        $product = $this->products->findOrFail($id);

        return $this->products->delete($product);
    }
}
