<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'product_mysql';

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
    ];
}
