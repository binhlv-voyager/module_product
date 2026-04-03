<?php

namespace Modules\Product\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Product\Models\Product;

interface ProductRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function findOrFail(int $id): Product;

    public function create(array $attributes): Product;

    public function update(Product $product, array $attributes): bool;

    public function delete(Product $product): ?bool;
}
