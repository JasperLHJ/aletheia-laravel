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
        Schema::dropIfExists('products');

        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->text('excerpt')->nullable();
            $table->string('featured_image', 500)->nullable();
            $table->unsignedSmallInteger('reading_time_minutes')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('category', 100)->nullable();
            $table->timestamp('published_at')->nullable();
        });

        Schema::dropIfExists('categories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'excerpt',
                'featured_image',
                'reading_time_minutes',
                'is_featured',
                'category',
                'published_at',
            ]);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->string('status')->default('active');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }
};
