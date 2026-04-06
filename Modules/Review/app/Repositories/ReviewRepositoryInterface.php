<?php

namespace Modules\Review\Repositories;

use Illuminate\Support\Collection;

interface ReviewRepositoryInterface
{
    public function all(): Collection;

    public function getByProductId(int $productId): Collection;

    public function existsByProductId(int $productId): bool;

    public function create(array $attributes): \Modules\Review\Models\Review;
}
