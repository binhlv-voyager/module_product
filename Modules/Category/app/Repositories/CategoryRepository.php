<?php

namespace Modules\Category\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::query()
            ->select(['id', 'name', 'slug'])
            ->orderBy('id')
            ->get();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Category::query()
            ->select(['id', 'name', 'slug'])
            ->orderBy('id')
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Category
    {
        return Category::query()
            ->select(['id', 'name', 'slug'])
            ->findOrFail($id);
    }

    public function create(array $attributes): Category
    {
        return Category::query()->create($attributes);
    }

    public function update(Category $category, array $attributes): bool
    {
        return $category->update($attributes);
    }

    public function delete(Category $category): ?bool
    {
        return $category->delete();
    }
}
