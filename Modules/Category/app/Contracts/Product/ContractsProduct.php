<?php

namespace Modules\Category\Contracts\Product;

interface ContractsProduct
{
    public function existsInCategory(int $categoryId): bool;
}

