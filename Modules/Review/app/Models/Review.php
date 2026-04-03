<?php

namespace Modules\Review\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $connection = 'review_mongo';

    protected $collection = 'reviews';

    protected $fillable = [
        'product_id',
        'author_name',
        'rating',
        'comment',
    ];
}
