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
        Schema::table('main_pages', function (Blueprint $table) {
            $table->foreignId('website_id')->default(1)->constrained('websites')->cascadeOnDelete()->cascadeOnUpdate();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_pages', function (Blueprint $table) {
            $table->dropColumn('website_id');            
        });
    }
};
