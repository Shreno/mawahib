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
        Schema::table('articles', function (Blueprint $table) {
            $table->string('app_name')->nullable(); // App Name
            $table->text('app_description')->nullable(); // App Description
            $table->string('app_link')->nullable(); // Icon Link
            $table->integer('download_count')->default(0); // Download Count
            $table->decimal('price', 8, 2)->nullable(); // Price
            $table->decimal('rating', 3, 2)->nullable(); // Rating
            $table->string('developer')->nullable(); // Developer
            $table->string('category')->nullable(); // Category
            $table->string('version')->nullable(); // Version
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            //
        });
    }
};
