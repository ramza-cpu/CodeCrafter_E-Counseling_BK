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
        Schema::create('konseling_message', function (Blueprint $table) {
            $table->id('id_message');

            $table->foreignId('id_session')
                ->constrained('konseling_session', 'id_session')
                ->cascadeOnDelete();

            $table->enum('sender', ['siswa', 'guru']);
            $table->text('message');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling_messages');
    }
};
