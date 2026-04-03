<?php

namespace Modules\Category\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;

interface CategoryRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function findOrFail(int $id): Category;

    public function create(array $attributes): Category;

    public function update(Category $category, array $attributes): bool;

    public function delete(Category $category): ?bool;
}
