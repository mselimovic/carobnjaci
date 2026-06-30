<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('status')->default('awaiting_seller')->after('message');
        });

        DB::table('messages')
            ->whereNull('read_at')
            ->update(['status' => 'awaiting_seller']);

        DB::table('messages')
            ->whereNotNull('read_at')
            ->update(['status' => 'awaiting_buyer']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
