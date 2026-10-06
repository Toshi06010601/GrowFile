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
        Schema::table('reading_logs', function (Blueprint $table) {
            $table->string('title', 255)->change();
            $table->string('author', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reading_logs', function (Blueprint $table) {
            $table->string('title', 100)->change();
            $table->string('author', 100)->change();
        });
    }
};
