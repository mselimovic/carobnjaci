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
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->nullable()->after('icon');
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->string('specialty')->nullable()->after('name');
            $table->text('bio')->nullable()->after('description');
            $table->string('response_time')->nullable()->after('phone');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('featured_image')->nullable()->after('description');
            $table->json('materials')->nullable()->after('featured_image');
            $table->string('lead_time')->nullable()->after('materials');
            $table->boolean('is_featured')->default(false)->after('contact_price');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->string('subject')->nullable()->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('subject');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'featured_image',
                'materials',
                'lead_time',
                'is_featured',
            ]);
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'specialty',
                'bio',
                'response_time',
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
