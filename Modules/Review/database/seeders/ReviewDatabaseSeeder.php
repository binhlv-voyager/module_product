<?php

namespace Modules\Review\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Models\Product;
use Modules\Review\Models\Review;

class ReviewDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = Product::query()->pluck('id')->all();

        if ($productIds === []) {
            return;
        }

        Review::query()->delete();

        $timestamp = now();
        $rows = [];

        for ($i = 1; $i <= 50; $i++) {
            $rows[] = [
                'product_id' => fake()->randomElement($productIds),
                'author_name' => fake()->name(),
                'rating' => fake()->numberBetween(1, 5),
                'comment' => fake()->sentence(mt_rand(10, 18)),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        Review::query()->insert($rows);
    }
}
