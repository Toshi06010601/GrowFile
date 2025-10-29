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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('full_name', 100)->index();
            $table->string('profile_image', 255)->nullable();
            $table->string('headline', 100)->nullable();
            $table->text('bio')->nullable();
            $table->enum('job_status', ['open', 'not_looking', 'freelance', 'exploring'])->nullable()->index();
            $table->boolean('visibility')->default(true);
            $table->string('location', 100)->nullable()->index();
            $table->string('github_link', 200)->nullable();
            $table->string('linkedin_link', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
