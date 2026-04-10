<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
            # Restriccion para valores unicos
            $table->unique(['book_id', 'member_id']);
        });

        DB::statement("
            ALTER TABLE book_reviews
            ADD CONSTRAINT CK_BOOKREVIEWS_RATING
            CHECK (rating BETWEEN 1 AND 5)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('book_reviews');
    }
};
