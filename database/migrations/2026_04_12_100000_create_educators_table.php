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
        Schema::create('educators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('image', 500)->nullable();
            $table->text('bio');
            $table->text('detail');
            $table->boolean('is_principal')->default(false);
            $table->string('status')->default('draft');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educators');
    }
};
