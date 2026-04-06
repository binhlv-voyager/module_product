<?php

namespace Modules\Review\Repositories;

use Illuminate\Support\Collection;
use Modules\Review\Models\Review;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function all(): Collection
    {
        return Review::query()
            ->orderByDesc('created_at')
            ->get(['product_id', 'author_name', 'rating', 'comment', 'created_at']);
    }

    public function getByProductId(int $productId): Collection
    {
        return Review::query()
            ->where('product_id', $productId)
            ->orderByDesc('created_at')
            ->get(['product_id', 'author_name', 'rating', 'comment', 'created_at']);
    }

    public function existsByProductId(int $productId): bool
    {
        return Review::query()
            ->where('product_id', $productId)
            ->limit(1)
            ->exists();
    }

    public function create(array $attributes): Review
    {
        return Review::query()->create($attributes);
    }
}
