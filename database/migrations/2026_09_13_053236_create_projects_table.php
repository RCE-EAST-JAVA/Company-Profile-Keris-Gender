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

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('category');
            $table->string('status')->default('Aktif');
            $table->string('image');
            $table->string('author')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('date')->nullable();
            $table->date('published_at')->nullable();
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
        Schema::dropIfExists('projects');
    }
};
