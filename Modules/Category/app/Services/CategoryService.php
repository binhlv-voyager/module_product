<?php

namespace Modules\Category\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Category\Contracts\Product\ContractsProduct;
use Modules\Category\Exceptions\CategoryHasProductsException;
use Modules\Category\Models\Category;
use Modules\Category\Repositories\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categories,
        private readonly ContractsProduct $products,
    ) {}

    public function getAllCategories(): Collection
    {
        return $this->categories->all();
    }

    public function paginateCategories(int $perPage = 10): LengthAwarePaginator
    {
        return $this->categories->paginate($perPage);
    }

    public function getCategoryById(int $id): Category
    {
        return $this->categories->findOrFail($id);
    }

    public function createCategory(array $attributes): Category
    {
        return $this->categories->create([
            'name' => $attributes['name'],
            'slug' => $this->normalizeSlug($attributes['slug'] ?? null, $attributes['name']),
        ]);
    }

    public function updateCategory(int $id, array $attributes): bool
    {
        $category = $this->categories->findOrFail($id);

        return $this->categories->update($category, [
            'name' => $attributes['name'],
            'slug' => $this->normalizeSlug($attributes['slug'] ?? null, $attributes['name']),
        ]);
    }

    public function deleteCategory(int $id): ?bool
    {
        $category = $this->categories->findOrFail($id);

        if ($this->products->existsInCategory($category->id)) {
            throw new CategoryHasProductsException('Cannot delete category because it still has products.');
        }

        return $this->categories->delete($category);
    }

    private function normalizeSlug(?string $slug, string $name): string
    {
        return Str::slug($slug ?: $name);
    }
}
