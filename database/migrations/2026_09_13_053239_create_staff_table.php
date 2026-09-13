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

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->enum('category', ["Research Assistant","Researcher"]);
            $table->string('expertise')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->nullable();
            $table->string('linkedin')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->index('sort_order');
            $table->index('category');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
