<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = Category::query()->pluck('id')->all();

        if ($categoryIds === []) {
            return;
        }

        Product::query()->truncate();

        $timestamp = now();
        $rows = [];

        for ($i = 1; $i <= 50; $i++) {
            $rows[] = [
                'name' => fake()->unique()->words(mt_rand(2, 4), true),
                'description' => fake()->paragraphs(mt_rand(2, 4), true),
                'price' => fake()->randomFloat(2, 10, 5000),
                'category_id' => fake()->randomElement($categoryIds),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        Product::query()->insert($rows);
    }
}
