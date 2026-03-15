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
        Schema::create('products', function (Blueprint $table) {
    $table->id();

    $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
    $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

    $table->string('title');
    $table->string('slug')->unique();

    $table->text('description')->nullable();

    $table->decimal('price', 10, 2)->nullable();
    $table->boolean('contact_price')->default(false);

    $table->enum('status', ['draft','pending','published','rejected'])->default('draft');

    $table->unsignedInteger('views')->default(0);

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
