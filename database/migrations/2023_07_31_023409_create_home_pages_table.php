<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['header', 'gallery', 'articles', 'event', 'front-shop-1',  'front-shop-2', 'front-shop-3', 'video', 'gallery-review', 'academy', 'product-catalog', 'breadcrumbs'])->nullable();
            $table->text('data')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
