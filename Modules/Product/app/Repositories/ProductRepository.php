<?php

namespace Modules\Product\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Product\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(): Collection
    {
        return Product::query()
            ->select(['id', 'name', 'description', 'price', 'category_id'])
            ->orderBy('id')
            ->get();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Product::query()
            ->select(['id', 'name', 'description', 'price', 'category_id'])
            ->orderBy('id')
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Product
    {
        return Product::query()
            ->select(['id', 'name', 'description', 'price', 'category_id'])
            ->findOrFail($id);
    }

    public function existsByCategoryId(int $categoryId): bool
    {
        return Product::query()
            ->where('category_id', $categoryId)
            ->exists();
    }

    public function create(array $attributes): Product
    {
        return Product::query()->create($attributes);
    }

    public function update(Product $product, array $attributes): bool
    {
        return $product->update($attributes);
    }

    public function delete(Product $product): ?bool
    {
        return $product->delete();
    }
}
