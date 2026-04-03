<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    protected $connection = 'review_mongo';

    public function up(): void
    {
        if (Schema::connection($this->connection)->hasTable('reviews')) {
            return;
        }

        Schema::connection($this->connection)->create('reviews', function (Blueprint $collection) {
            $collection->index('product_id');
            $collection->index('rating');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('reviews');
    }
};
