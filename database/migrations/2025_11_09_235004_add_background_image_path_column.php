<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The column is now also defined in the create_profiles_table migration, so it
     * is only added here for databases created before that change.
     */
    public function up(): void
    {
        if (Schema::hasColumn('profiles', 'background_image_path')) {
            return;
        }

        Schema::table('profiles', function (Blueprint $table) {
            $table->string('background_image_path', 255)->after('profile_image_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * Intentionally empty: the column belongs to the create_profiles_table migration,
     * which drops it along with the table.
     */
    public function down(): void
    {
        //
    }
};
