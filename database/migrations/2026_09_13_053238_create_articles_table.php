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
        Schema::disableForeignKeyConstraints();

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('author')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('category');
            $table->enum('status', ["draft","published"])->default('draft');
            $table->string('tags')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->index(['status', 'published_at']);
            $table->index(['is_pinned', 'published_at']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
