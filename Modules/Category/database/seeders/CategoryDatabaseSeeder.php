<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('category_pgsql')->statement('TRUNCATE TABLE categories RESTART IDENTITY CASCADE');

        $timestamp = now();
        $rows = [];

        for ($i = 1; $i <= 50; $i++) {
            $name = fake()->unique()->words(mt_rand(2, 3), true);

            $rows[] = [
                'name' => Str::title($name),
                'slug' => Str::slug($name).'-'.$i,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        Category::query()->insert($rows);
    }
}
