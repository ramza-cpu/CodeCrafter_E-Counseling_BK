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
            $table->bigIncrements('id_message');
            $table->unsignedBigInteger('id_session');

            $table->enum('sender', ['siswa', 'guru']);
            $table->text('message');

            $table->timestamps();

            $table->foreign('id_session')
                ->references('id_session')->on('konseling_session')
                ->onDelete('cascade');
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
