<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('isbn', 13)->unique();
            $table->string('publisher', 200)->nullable();
            $table->unsignedSmallInteger('publish_year')->nullable();
            $table->unsignedInteger('pages')->nullable();
            $table->string('language', 50)->default('Español');
            $table->text('description')->nullable();
            $table->string('cover_url', 500)->nullable();
            $table->unsignedInteger('total_copies')->default(1);
            $table->unsignedInteger('available_copies')->default(1);
            $table->enum('status', ['available', 'reserved', 'unavailable'])->default('available');
            $table->foreignId('category_id')->constrained('categories')->nullable()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            # Indices para busquedas comunes
            $table->index('title');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
