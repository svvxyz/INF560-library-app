<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('members_code', 20)->unique();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->enum('membership_type', ['standard', 'premium', 'student'])->default('standard');
            $table->date('membership_expires_at')->nullable();
            $table->unsignedTinyInteger('max_loans')->default(3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::statement("
            ALTER TABLE members
            ADD CONSTRAINT CK_MEMBERS_CODE 
            CHECK (members_code ~ '^LIB-20[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])$')
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
