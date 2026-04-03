<?php

namespace Modules\Category\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;

interface CategoryServiceInterface
{
    public function getAllCategories(): Collection;

    public function paginateCategories(int $perPage = 10): LengthAwarePaginator;

    public function getCategoryById(int $id): Category;

    public function createCategory(array $attributes): Category;

    public function updateCategory(int $id, array $attributes): bool;

    public function deleteCategory(int $id): ?bool;
}
