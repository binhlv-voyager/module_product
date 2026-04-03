<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'product_mysql';

    public function up(): void
    {
        Schema::connection($this->connection)->create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->index('category_id');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('products');
    }
};
