<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'category_pgsql';

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
    ];
}
